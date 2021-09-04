<?php

namespace App\filter\controller;

use App\services as srv;


class FilterManager
{
    private static $instance = null;

    private $sessionServ;

    private $FILTER_SETTINGS_KEY = 'filterSettings';

    public function __construct()
    {
        $this->sessionServ = srv\SessionService::getInstance();
    }

    public function action()
    {
        $this->sessionServ->set($this->FILTER_SETTINGS_KEY, [
            'categories' => $_POST['categories'],
            'minPrice' => $_POST['minPrice'],
            'maxPrice' => $_POST['maxPrice'],
            'search' => $_POST['search']
        ]);
    }

    public function isCategorySelected(string $category)
    {
        if (!$this->sessionServ->exists($this->FILTER_SETTINGS_KEY))
            return false;
        $categories = $this->sessionServ->get($this->FILTER_SETTINGS_KEY)['categories'];

        if (empty($categories)) 
            return false;

        foreach ($categories as $categorie)
        {
            if ($categorie === $category)
                return true;
        }

        return false;
    }

    public function getPricesTab()
    {
        if (!$this->sessionServ->exists($this->FILTER_SETTINGS_KEY))
            return ['min' => '0', 'max' => '0'];

        $data = $this->sessionServ->get($this->FILTER_SETTINGS_KEY);
        $minPrice = $data['minPrice'];
        $maxPrice = $data['maxPrice'];

        return ['min' => $minPrice, 'max' => $maxPrice];
    }

    public static function getInstance()
    {
        if (is_null(self::$instance))
            self::$instance = new FilterManager();

        return self::$instance;
    }

    public function filterArticles($articles)
    {
        if (!$this->sessionServ->exists($this->FILTER_SETTINGS_KEY))
            return $articles;

        $filterSearch = $this->sessionServ->get($this->FILTER_SETTINGS_KEY)['search'];

        if (!empty($filterSearch))
            return $this->filterByString($articles, $filterSearch);
        
        $res = $this->filterByCategory($articles);
        return $this->filterByPrice($res);
    }

    public function deleteData()
    {
        $this->sessionServ->delete($this->FILTER_SETTINGS_KEY);
    }

    private function filterByCategory($articles)
    {
        $res = [];
        $categories = $this->sessionServ->get($this->FILTER_SETTINGS_KEY)['categories'];
        if (empty($categories))
            return $articles;
        foreach ($articles as $article)
        {
            foreach ($categories as $categorie)
            {
                if ($article['categorie'] === $categorie)
                    $res[] = $article;
            }
        }

        return $res;
    }

    private function filterByPrice($articles)
    {
        $data = $this->sessionServ->get($this->FILTER_SETTINGS_KEY);
        $minPrice = $data['minPrice'];
        $maxPrice = $data['maxPrice'];

        if (empty($minPrice))
            $minPrice = 0;
        if (empty($maxPrice))
            $maxPrice = PHP_FLOAT_MAX;
        $res = [];
        foreach ($articles as $article)
        {
            if ($article['prix'] >= $minPrice && $article['prix'] <= $maxPrice)
                $res[] = $article;

        }
        return $res;
    }

    private function filterByString($articles, $str)
    {
        $res = [];

        foreach ($articles as $article)
        {
            if (stripos($article['nom'], $str) !== false)
                $res[] = $article;
        }

        return $res;

    }

}
?>