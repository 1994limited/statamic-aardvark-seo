<?php

namespace WithCandour\AardvarkSeo\Http\Controllers\CP;

use Statamic\CP\Breadcrumbs;
use Statamic\Facades\Site;
use WithCandour\AardvarkSeo\Http\Controllers\CP\Contracts\Publishable;
use WithCandour\AardvarkSeo\Blueprints\CP\MarketingSettingsBlueprint;
use WithCandour\AardvarkSeo\Facades\AardvarkStorage;

class MarketingController extends Controller implements Publishable
{
    public function index()
    {
        $this->authorize('view aardvark marketing settings');

        $data = $this->getData();

        $blueprint = $this->getBlueprint();
        $fields = $blueprint->fields()->addValues($data)->preProcess();

        $crumbs = Breadcrumbs::make([
            ['text' => 'Aardvark SEO', 'url' => url(config('statamic.cp.route') . '/aardvark-seo/settings')],
            ['text' => 'Marketing Settings', 'url' => url(config('statamic.cp.route') . '/aardvark-seo/settings/marketing')],
        ]);

        return view('aardvark-seo::cp.settings.marketing', [
            'blueprint' => $blueprint->toPublishArray(),
            'crumbs' => $crumbs,
            'meta' => $fields->meta(),
            'title' => 'Marketing Settings | Aardvark SEO',
            'values' => $fields->values(),
        ]);
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $this->authorize('update aardvark marketing settings');

        $blueprint = $this->getBlueprint();

        $fields = $blueprint->fields()->addValues($request->all());
        $fields->validate();

        $this->putData($fields->process()->values()->toArray());
    }

    /**
     * @inheritdoc
     */
    public function getBlueprint()
    {
        return MarketingSettingsBlueprint::requestBlueprint();
    }

    /**
     * @inheritdoc
     */
    public function getData()
    {
        return AardvarkStorage::getYaml('marketing', Site::selected());
    }

    /**
     * @inheritdoc
     */
    public function putData($data)
    {
        return AardvarkStorage::putYaml('marketing', Site::selected(), $data);
    }
}
