<?php
// api.php — Backend GitHub API proxy.
// The frontend calls this file; the token never leaves the server.

declare(strict_types=1);

require_once __DIR__ . '/secrets.php';

header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');

// ── Simple rate-limit / abuse guard ──────────────────────────────────────────
// Only allow requests from the same origin (same-site XHR).
// Browsers always send Origin or Referer for cross-site requests.
$origin  = $_SERVER['HTTP_ORIGIN']  ?? '';
$referer = $_SERVER['HTTP_REFERER'] ?? '';
$allowed = ['opensource.xpsystems.eu', 'opensource.xpsystems.de', 'localhost', '127.0.0.1'];

$callerOk = false;
foreach ($allowed as $host) {
    if (str_contains($origin, $host) || str_contains($referer, $host)) {
        $callerOk = true;
        break;
    }
}
// Allow if no origin header (e.g. direct server-side request or curl during dev)
if ($origin === '' && $referer === '') $callerOk = true;

if (!$callerOk) {
    http_response_code(403);
    echo json_encode(['error' => 'Forbidden']);
    exit;
}

// ── Routing ───────────────────────────────────────────────────────────────────
$action = $_GET['action'] ?? '';

$result = match ($action) {
    'org_repos' => handleOrgRepos(),
    'user_repos' => handleUserRepos(),
    'org_info'   => handleOrgInfo(),
    'user_info'  => handleUserInfo(),
    'all_repos'  => handleAllRepos(),
    default      => ['error' => 'Unknown action'],
};

echo json_encode($result);
exit;

// ── Helpers ───────────────────────────────────────────────────────────────────

function githubGet(string $path): mixed
{
    $url = 'https://api.github.com' . $path;
    $ctx = stream_context_create([
        'http' => [
            'method'  => 'GET',
            'header'  => implode("\r\n", [
                'User-Agent: xpsystems-opensource/1.0',
                'Accept: application/vnd.github+json',
                'Authorization: Bearer ' . GITHUB_TOKEN,
                'X-GitHub-Api-Version: 2022-11-28',
            ]),
            'timeout' => 10,
            'ignore_errors' => true,
        ],
    ]);

    $raw  = file_get_contents($url, false, $ctx);
    $code = 0;

    // Parse HTTP status from response headers
    foreach ($http_response_header ?? [] as $h) {
        if (preg_match('#^HTTP/\S+\s+(\d+)#', $h, $m)) {
            $code = (int) $m[1];
        }
    }

    if ($raw === false || $code >= 400) {
        return ['_error' => true, '_code' => $code, '_url' => $url];
    }

    return json_decode($raw, true);
}

// Paginate through all pages of a list endpoint (returns flat array)
function githubGetAll(string $path): array
{
    $page    = 1;
    $results = [];

    do {
        $sep  = str_contains($path, '?') ? '&' : '?';
        $data = githubGet("{$path}{$sep}per_page=100&page={$page}");

        if (!is_array($data) || isset($data['_error'])) break;
        // org/user info endpoint returns an object, not a list
        if (isset($data['id'])) return $data;

        $results = array_merge($results, $data);
        $page++;
    } while (count($data) === 100);

    return $results;
}

// ── Action handlers ───────────────────────────────────────────────────────────

function handleOrgRepos(): array
{
    $org = preg_replace('/[^a-zA-Z0-9\-]/', '', $_GET['org'] ?? '');
    if (!$org) return ['error' => 'Missing org parameter'];
    return githubGetAll("/orgs/{$org}/repos?type=public&sort=updated");
}

function handleUserRepos(): array
{
    $user = preg_replace('/[^a-zA-Z0-9\-]/', '', $_GET['user'] ?? '');
    if (!$user) return ['error' => 'Missing user parameter'];
    return githubGetAll("/users/{$user}/repos?type=public&sort=updated");
}

function handleOrgInfo(): array
{
    $org = preg_replace('/[^a-zA-Z0-9\-]/', '', $_GET['org'] ?? '');
    if (!$org) return ['error' => 'Missing org parameter'];
    $data = githubGet("/orgs/{$org}");
    return is_array($data) ? $data : ['error' => 'Not found'];
}

function handleUserInfo(): array
{
    $user = preg_replace('/[^a-zA-Z0-9\-]/', '', $_GET['user'] ?? '');
    if (!$user) return ['error' => 'Missing user parameter'];
    $data = githubGet("/users/{$user}");
    return is_array($data) ? $data : ['error' => 'Not found'];
}

// Convenience: fetch repos for all known sources in one backend call
function handleAllRepos(): array
{
    $orgs  = ['xpsystems'];       // GitHub organisations
    $users = ['xpsystems-ai'];    // GitHub users (not orgs)

    $all = [];

    foreach ($orgs as $org) {
        $repos = githubGetAll("/orgs/{$org}/repos?type=public&sort=updated");
        if (is_array($repos) && !isset($repos['_error'])) {
            foreach ($repos as &$r) $r['_source'] = $org;
            $all = array_merge($all, $repos);
        }
    }

    foreach ($users as $user) {
        $repos = githubGetAll("/users/{$user}/repos?type=public&sort=updated");
        if (is_array($repos) && !isset($repos['_error'])) {
            foreach ($repos as &$r) $r['_source'] = $user;
            $all = array_merge($all, $repos);
        }
    }

    return $all;
}