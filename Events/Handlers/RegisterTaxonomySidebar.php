<?php

namespace Modules\Taxonomy\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterTaxonomySidebar implements \Maatwebsite\Sidebar\SidebarExtender
{
    /**
     * @var Authentication
     */
    protected $auth;

    /**
     * @param Authentication $auth
     *
     * @internal param Guard $guard
     */
    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    public function handle(BuildingSidebar $sidebar)
    {
        $sidebar->add($this->extendWith($sidebar->getMenu()));
    }

    /**
     * @param Menu $menu
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $menu->group(trans('core::sidebar.content'), function (Group $group) {
            $group->item(trans('taxonomy::taxonomies.title.taxonomies'), function (Item $item) {
                $item->icon('fa fa-sitemap');
                $item->weight(10);
                $item->authorize(
                    $this->auth->hasAccess('taxonomy.vocabularies.index')
                );
                $item->route('admin.taxonomy.vocabulary.index');
                /*$item->item(trans('taxonomy::vocabularies.title.vocabularies'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.taxonomy.vocabulary.create');
                    $item->route('admin.taxonomy.vocabulary.index');
                    $item->authorize(
                        $this->auth->hasAccess('taxonomy.vocabularies.index')
                    );
                });
                $item->item(trans('taxonomy::terms.title.terms'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.taxonomy.term.create');
                    $item->route('admin.taxonomy.term.index');
                    $item->authorize(
                        $this->auth->hasAccess('taxonomy.terms.index')
                    );
                });*/
// append


            });
        });

        return $menu;
    }
}
