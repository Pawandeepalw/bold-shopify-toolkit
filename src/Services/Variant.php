<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\Metafield as ShopifyMetafield;
use BoldApps\ShopifyToolkit\Models\Product as ShopifyProduct;
use BoldApps\ShopifyToolkit\Models\Variant as ShopifyVariant;
use Illuminate\Support\Collection;

/**
 * Class Variant.
 */
class Variant extends Base
{
    /**
     * @param ShopifyProduct $product
     * @param ShopifyVariant $variant
     *
     * @return object
     */
    public function create(ShopifyProduct $product, ShopifyVariant $variant)
    {
        $serializedModel = ['variant' => $this->serializeModel($variant)];

        $raw = $this->client->post("admin/products/{$product->getId()}/variants.json", [], $serializedModel);

        return $this->unserializeModel($raw['variant'], ShopifyVariant::class);
    }

    /**
     * @param $array
     *
     * @return object
     */
    public function createFromArray($array)
    {
        return $this->unserializeModel($array, ShopifyVariant::class);
    }

    /**
     * @param $id
     *
     * @return ShopifyVariant
     */
    public function getById($id)
    {
        $raw = $this->client->get("admin/variants/$id.json");

        return $this->unserializeModel($raw['variant'], ShopifyVariant::class);
    }

    /**
     * @param ShopifyVariant $variant
     *
     * @return object
     */
    public function update(ShopifyVariant $variant)
    {
        $serializedModel = ['variant' => $this->serializeModel($variant)];

        $raw = $this->client->put("admin/variants/{$variant->getId()}.json", [], $serializedModel);

        return $this->unserializeModel($raw['variant'], ShopifyVariant::class);
    }

    /**
     * @param ShopifyProduct $product
     * @param ShopifyVariant $variant
     *
     * @return object
     */
    public function delete(ShopifyProduct $product, ShopifyVariant $variant)
    {
        return $this->client->delete("admin/products/{$product->getId()}/variants/{$variant->getId()}.json");
    }

    /**
     * @param ShopifyVariant   $variant
     * @param ShopifyMetafield $metafield
     *
     * @return Collection
     **/
    public function createMetafield(ShopifyVariant $variant, ShopifyMetafield $metafield)
    {
        $serializedModel = ['metafield' => array_merge($this->serializeModel($metafield))];

        $raw = $this->client->post("admin/variants/{$variant->getId()}/metafields.json", [], $serializedModel);

        return $this->unserializeModel($raw['metafield'], ShopifyMetafield::class);
    }

    /**
     * @param ShopifyVariant $variant
     * @param ShopifyMetafield $metafield
     *
     * @return Collection
     */
    public function updateMetafield(ShopifyVariant $variant, ShopifyMetafield $metafield)
    {
        $serializedModel = ['metafield' => array_merge($this->serializeModel($metafield))];

        $raw = $this->client->put("admin/variants/{$variant->getId()}/metafields/{$metafield->getId()}.json", [], $serializedModel);

        return $this->unserializeModel($raw['metafield'], ShopifyMetafield::class);
    }

    /**
     * @param ShopifyVariant $variant
     *
     * @return Collection
     */
    public function getMetafields(ShopifyVariant $variant)
    {
        $raw = $this->client->get("admin/variants/{$variant->getId()}/metafields.json");

        $metafields = array_map(function ($metafield) {
            return $this->unserializeModel($metafield, ShopifyMetafield::class);
        }, $raw['metafields']);

        return new Collection($metafields);
    }

    /**
     * @param ShopifyVariant $variant
     * @param ShopifyMetafield $metafield
     *
     * @return Collection
     */
    public function deleteMetafield(ShopifyVariant $variant, ShopifyMetafield $metafield)
    {
        return $this->client->delete("admin/variants/{$variant->getId()}/metafields/{$metafield->getId()}.json");
    }

    /**
     * @param ShopifyMetafield $metafield
     *
     * @return Collection
     */
    public function deleteMetafieldById(ShopifyMetafield $metafield)
    {
        return $this->client->delete("admin/metafields/{$metafield->getId()}.json");
    }
}
