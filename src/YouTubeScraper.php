<?php

namespace Codespace\PhpChallenges;

class YouTubeScraper {
    private $apiKey;
  
    public function __construct($apiKey) {
      $this->apiKey = $apiKey;
    }
  
    public function getVideoStatisticsFromVideo($videoId) {
      // Set up the API request URL
      $url = "https://www.googleapis.com/youtube/v3/videos?part=statistics&id=$videoId&key=$this->apiKey";
  
      // Use file_get_contents() to send the API request and get the response
      $response = file_get_contents($url);
  
      // Decode the JSON response into an array
      $data = json_decode($response, true);
  
      // Extract the view count and like count from the response
      $viewCount = $data['items'][0]['statistics']['viewCount'];
      $likeCount = $data['items'][0]['statistics']['likeCount'];
  
      // Return an array with the view count and like count
      return [
        'viewCount' => $viewCount,
        'likeCount' => $likeCount
      ];
    }
  }
  