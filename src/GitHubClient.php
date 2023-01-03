<?php

namespace Codespace\PhpChallenges;


class GitHubClient
{
    private $apiUrl = 'https://api.github.com/users/{USERNAME}/repos';

    public function __construct(string $username)
    {
        $this->apiUrl = str_replace('{USERNAME}', $username, $this->apiUrl);
    }

    public function get(string $url): string
    {
        // without context it wont work
        $context = stream_context_create([
            'http' => [
                    'method' => 'GET',
                    'header' => [
                            'User-Agent: PHP'
                    ]
            ]
        ]);
    
        return file_get_contents($url, false, $context);
    }

    public function printRepoSize(): int
    {
        $response = $this->get($this->apiUrl);
        $repos = json_decode($response, true);
        $totalSize = 0;

        foreach ($repos as $repo) {
            $totalSize += $repo['size'];
        }

        return $totalSize;
    }
}
