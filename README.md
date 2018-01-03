# Taxonomy module
Simple module that help you to manage your taxonomy (category)

## Installation

### Composer

``` bash
composer require daothanh/taxonomy
php artisan module:migrate Taxonomy
```
### Add Routes

Go to  `reosources/assets/js/app.js`
- Import Routes: `import TaxonomyRoutes from '../../../Modules/Taxonomy/Assets/js/TaxonomyRoutes';`
- Add `TaxonomyRoutes` to router: `...TaxonomyRoutes,`
- Build webpack by `npm run dev`

## Link Term to Entity

### 1. Adding the `Termable` trait

First thing you need is add `Modules\Taxonomy\Support\Traits\Termable` trait onto your Entity
This will add a `terms` morphToMany relation onto your entity.

Example:

```php
<?php

namespace Modules\Post\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\NamespacedEntity;
use Modules\Taxonomy\Support\Traits\Termable;

class Post extends Model
{
    use Translatable, NamespacedEntity, Termable;

    protected $table = 'post__posts';
    public $translatedAttributes = [];
    protected $fillable = [];
}
```
### 2. Trigger event on create and update

On created and updated envents of entity you implement `Modules\Taxonomy\Contracts\TermLink` Interface

Example:
```php
<?php

namespace Modules\Post\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Post\Entities\Post;
use Modules\Taxonomy\Contracts\TermLink;

class PostWasCreated implements TermLink
{
    use SerializesModels;

    /** @var Post $entity */
    private $entity;

    /** @var array $data */
    private $data;

	/**
	 * Create a new event instance.
	 *
	 * @param Post $post
	 * @param array $data
	 */
    public function __construct(Post $post, array $data)
    {
        $this->entity = $post;
        $this->data = $data;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }

	/**
	 * Return the entity
	 * @return \Illuminate\Database\Eloquent\Model|Post
	 */
	public function getEntity() {
		return $this->entity;
	}

	/**
	 * Return the ALL data sent
	 * @return array
	 */
	public function getSubmissionData() {
		return $this->data;
	}
}
```

### 3. Adding the Terms Box component

Example:

```html
<template>
    <terms-box :vocabulary-id="1" :entity-id="$route.params.post" entity="Modules\Post\Entities\Post"
                               @changeTerm="handleChangeTerm"></terms-box>
</template>

<script>
    import TermsBox from "../../../../Taxonomy/Assets/js/components/TermsBox";

    export default {
        components: {TermsBox},
        data() {
            return {
                post: {}
            }
        },
        methods: {
            handleChangeTerm(terms) {
                this.post.term_ids = terms;
            }
        },
        mounted() {
        },
    };
</script>
```
