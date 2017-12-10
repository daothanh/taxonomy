<?php

namespace Modules\Taxonomy\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Taxonomy\Blade\TaxonomyChooseTermsDirective;
use Modules\Taxonomy\Contracts\DeletingTerm;
use Modules\Taxonomy\Contracts\TermHierarchy;
use Modules\Taxonomy\Contracts\TermLink;
use Modules\Taxonomy\Events\Handlers\HandleTermHierarchy;
use Modules\Taxonomy\Events\Handlers\HandleTermLink;
use Modules\Taxonomy\Events\Handlers\RegisterTaxonomySidebar;
use Modules\Taxonomy\Events\Handlers\RemoveTermPolymorphicLink;

class TaxonomyServiceProvider extends ServiceProvider {

	use CanPublishConfiguration;

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register() {
		$this->registerBindings();
		$this->app['events']->listen( BuildingSidebar::class, RegisterTaxonomySidebar::class );
		$this->app['events']->listen( LoadingBackendTranslations::class, function ( LoadingBackendTranslations $event ) {
			$event->load( 'vocabularies', array_dot( trans( 'taxonomy::vocabularies' ) ) );
			$event->load( 'terms', array_dot( trans( 'taxonomy::terms' ) ) );
		} );
	}

	public function boot( DispatcherContract $events ) {
		$this->publishConfig( 'taxonomy', 'permissions' );
		$this->publishConfig( 'taxonomy', 'assets' );

		$events->listen( TermHierarchy::class, HandleTermHierarchy::class );
		$events->listen( TermLink::class, HandleTermLink::class );
		$events->listen( DeletingTerm::class, RemoveTermPolymorphicLink::class );
		$events->listen( DeletingTerm::class, RemoveTermPolymorphicLink::class );

		$this->loadMigrationsFrom( __DIR__ . '/../Database/Migrations' );
		$this->app['blade.compiler']->directive( 'taxonomyChooseTerms', function ( $value ) {
			return "<?php echo TaxonomyChooseTermsDirective::show([$value]); ?>";
		} );
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides() {
		return [];
	}

	private function registerBindings() {
		$this->app->bind(
			'Modules\Taxonomy\Repositories\VocabularyRepository',
			function () {
				$repository = new \Modules\Taxonomy\Repositories\Eloquent\EloquentVocabularyRepository( new \Modules\Taxonomy\Entities\Vocabulary() );

				if ( ! config( 'app.cache' ) ) {
					return $repository;
				}

				return new \Modules\Taxonomy\Repositories\Cache\CacheVocabularyDecorator( $repository );
			}
		);
		$this->app->bind(
			'Modules\Taxonomy\Repositories\TermRepository',
			function () {
				$repository = new \Modules\Taxonomy\Repositories\Eloquent\EloquentTermRepository( new \Modules\Taxonomy\Entities\Term() );

				if ( ! config( 'app.cache' ) ) {
					return $repository;
				}

				return new \Modules\Taxonomy\Repositories\Cache\CacheTermDecorator( $repository );
			}
		);
		$this->app->bind( 'taxonomy.choose.terms.directive', function () {
			return new TaxonomyChooseTermsDirective();
		} );
		// add bindings


	}
}
