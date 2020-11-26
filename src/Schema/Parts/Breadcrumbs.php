<?php

namespace WithCandour\AardvarkSeo\Schema\Parts;

use Spatie\SchemaOrg\Schema;
use Statamic\Facades\Config;
use Statamic\Facades\Entry;
use Statamic\Facades\Site;
use Statamic\Facades\Term;
use Statamic\Facades\URL;
use WithCandour\AardvarkSeo\Schema\SchemaIds;
use WithCandour\AardvarkSeo\Schema\Parts\Contracts\SchemaPart;

class Breadcrumbs implements SchemaPart
{
    /**
     * Similar to how NavTags->breadcrumbs works
     */
    public function list()
    {
        $crumbs = [];

        $url = URL::getCurrent();
        $locale = Config::getFullLocale();

        $segments = explode('/', $url);
        $segments[0] = '/';

        // Create crumbs from segments
        $crumbs = collect($segments)->map(function () use (&$segments) {
            $uri = URL::tidy(join('/', $segments));
            array_pop($segments);

            return $uri;
        })->mapWithKeys(function ($uri) {
            $entry = Entry::findByUri($uri, Site::current()->handle());
            if($entry) {
                return [$uri => $entry];
            }
            $term = Term::findByUri($uri, Site::current()->handle());
            if($term) {
                return [$uri => $term];
            }

            return [$uri => null];
        })->filter();

        return $crumbs->reverse();

    }

    public function data()
    {
        $breadcrumbs = Schema::breadcrumbList();
        $crumbs = $this->list();

        $position = 1;
        $listItems = [];
        foreach($crumbs as $crumb) {
            $listItem = Schema::listItem();
            $listItem->position($position);
            $item = Schema::thing();
            $item->name($crumb->get('title'));
            $item->setProperty('id', $crumb->absoluteUrl());
            $listItem->item($item);
            $listItems[] = $listItem;
            $position++;
        }

        $breadcrumbs->itemListElement($listItems);
        return $breadcrumbs;
    }

    public static function id()
    {
        return URL::makeAbsolute(Config::getSiteUrl()) . SchemaIds::BREADCRUMBS;
    }
}
