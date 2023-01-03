<?php

namespace Codespace\PhpChallenges;

class Scraper {
    public function getProductDescriptions($url) {
      $descriptions = [];

      $html = file_get_contents($url);

      // Use preg_match_all() to find all the product description elements
      preg_match_all("/<div class=\"card-title ts-card__title--portrait\">(.*?)<\/div>/", $html, $matches);

      foreach ($matches[1] as $match) {
        $descriptions[] = substr($match, 0, 50);
      }

      return $descriptions;
    }
}
