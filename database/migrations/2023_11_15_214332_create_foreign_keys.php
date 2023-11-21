<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('users', function(Blueprint $table) {
			$table->foreign('tier_id')->references('id')->on('tiers')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('addresses', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('cascade');
		});
		Schema::table('reviews', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('favourites', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('search_histories', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('countries', function(Blueprint $table) {
			$table->foreign('currency_id')->references('id')->on('currencies')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('country_translations', function(Blueprint $table) {
			$table->foreign('country_id')->references('id')->on('countries')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('currency_translations', function(Blueprint $table) {
			$table->foreign('currency_id')->references('id')->on('currencies')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('devices', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('set null')
						->onUpdate('restrict');
		});
		Schema::table('subsections', function(Blueprint $table) {
			$table->foreign('section_id')->references('id')->on('sections')
						->onDelete('restrict')
						->onUpdate('cascade');
		});
		Schema::table('coupons', function(Blueprint $table) {
			$table->foreign('store_id')->references('id')->on('stores')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('coupon_users', function(Blueprint $table) {
			$table->foreign('coupon_id')->references('id')->on('coupons')
						->onDelete('restrict')
						->onUpdate('cascade');
		});
		Schema::table('coupon_users', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('cascade');
		});
		Schema::table('orders', function(Blueprint $table) {
			$table->foreign('offer_id')->references('id')->on('offers')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('orders', function(Blueprint $table) {
			$table->foreign('driver_id')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('orders', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('orders', function(Blueprint $table) {
			$table->foreign('default_currency_id')->references('id')->on('currencies')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('orders', function(Blueprint $table) {
			$table->foreign('from_address')->references('id')->on('addresses')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('orders', function(Blueprint $table) {
			$table->foreign('to_address')->references('id')->on('addresses')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('orders', function(Blueprint $table) {
			$table->foreign('address_id')->references('id')->on('addresses')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('orders', function(Blueprint $table) {
			$table->foreign('coupon_id')->references('id')->on('coupons')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('order_items', function(Blueprint $table) {
			$table->foreign('order_id')->references('id')->on('orders')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('order_items', function(Blueprint $table) {
			$table->foreign('item_id')->references('id')->on('items')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('order_items', function(Blueprint $table) {
			$table->foreign('size_id')->references('id')->on('sizes')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('order_items', function(Blueprint $table) {
			$table->foreign('option_id')->references('id')->on('options')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('order_items', function(Blueprint $table) {
			$table->foreign('preference_id')->references('id')->on('preferences')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('carts', function(Blueprint $table) {
			$table->foreign('item_id')->references('id')->on('items')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('carts', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('carts', function(Blueprint $table) {
			$table->foreign('size_id')->references('id')->on('sizes')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('carts', function(Blueprint $table) {
			$table->foreign('preference_id')->references('id')->on('preferences')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('carts', function(Blueprint $table) {
			$table->foreign('option_id')->references('id')->on('options')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('carts', function(Blueprint $table) {
			$table->foreign('gift_id')->references('id')->on('item_gifts')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('punchcards', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('notifications', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('tier_translations', function(Blueprint $table) {
			$table->foreign('tier_id')->references('id')->on('tiers')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('providers', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('status_translations', function(Blueprint $table) {
			$table->foreign('status_id')->references('id')->on('statuses')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('order_statuses', function(Blueprint $table) {
			$table->foreign('order_id')->references('id')->on('orders')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('order_statuses', function(Blueprint $table) {
			$table->foreign('status_id')->references('id')->on('statuses')
						->onDelete('restrict')
						->onUpdate('restrict');
		});

		Schema::table('section_translations', function(Blueprint $table) {
			$table->foreign('section_id')->references('id')->on('sections')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('subsection_translations', function(Blueprint $table) {
			$table->foreign('sub_section_id')->references('id')->on('subsections')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('stores', function(Blueprint $table) {
			$table->foreign('default_currency_id')->references('id')->on('currencies')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('stores', function(Blueprint $table) {
			$table->foreign('to_currency_id')->references('id')->on('currencies')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('stores', function(Blueprint $table) {
			$table->foreign('admin_id')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('stores', function(Blueprint $table) {
			$table->foreign('sub_section_id')->references('id')->on('subsections')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('store_translations', function(Blueprint $table) {
			$table->foreign('store_id')->references('id')->on('stores')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('point_users', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('point_stores', function(Blueprint $table) {
			$table->foreign('store_id')->references('id')->on('stores')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('offers', function(Blueprint $table) {
			$table->foreign('store_id')->references('id')->on('stores')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('offers', function(Blueprint $table) {
			$table->foreign('tier_id')->references('id')->on('tiers')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('offer_users', function(Blueprint $table) {
			$table->foreign('offer_id')->references('id')->on('offers')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('offer_users', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('store_categories', function(Blueprint $table) {
			$table->foreign('store_id')->references('id')->on('stores')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('store_category_translations', function(Blueprint $table) {
			$table->foreign('store_category_id')->references('id')->on('store_categories')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('drink_translations', function(Blueprint $table) {
			$table->foreign('drink_id')->references('id')->on('drinks')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('ingredients', function(Blueprint $table) {
			$table->foreign('item_id')->references('id')->on('items')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('items', function(Blueprint $table) {
			$table->foreign('category_id')->references('id')->on('store_categories')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('items', function(Blueprint $table) {
			$table->foreign('store_id')->references('id')->on('stores')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('items', function(Blueprint $table) {
			$table->foreign('default_currency_id')->references('id')->on('currencies')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('Item_translations', function(Blueprint $table) {
			$table->foreign('item_id')->references('id')->on('items')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('ingredient_translations', function(Blueprint $table) {
			$table->foreign('ingredient_id')->references('id')->on('ingredients')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('item_addons', function(Blueprint $table) {
			$table->foreign('item_id')->references('id')->on('items')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('item_addons', function(Blueprint $table) {
			$table->foreign('addon_id')->references('id')->on('addons')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('item_drinks', function(Blueprint $table) {
			$table->foreign('item_id')->references('id')->on('items')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('item_drinks', function(Blueprint $table) {
			$table->foreign('drink_id')->references('id')->on('drinks')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('offer_tanslations', function(Blueprint $table) {
			$table->foreign('offer_id')->references('id')->on('offers')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('sides', function(Blueprint $table) {
			$table->foreign('item_id')->references('id')->on('items')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('side_translations', function(Blueprint $table) {
			$table->foreign('side_id')->references('id')->on('sides')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('sizes', function(Blueprint $table) {
			$table->foreign('item_id')->references('id')->on('items')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('size_translations', function(Blueprint $table) {
			$table->foreign('size_id')->references('id')->on('sizes')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('item_gifts', function(Blueprint $table) {
			$table->foreign('item_id')->references('id')->on('items')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('wallets', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('wallets', function(Blueprint $table) {
			$table->foreign('primary_currency_id')->references('id')->on('currencies')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('options', function(Blueprint $table) {
			$table->foreign('item_id')->references('id')->on('items')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('preferences', function(Blueprint $table) {
			$table->foreign('item_id')->references('id')->on('items')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('services', function(Blueprint $table) {
			$table->foreign('item_id')->references('id')->on('items')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('preference_translations', function(Blueprint $table) {
			$table->foreign('preference_id')->references('id')->on('preferences')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('service_translations', function(Blueprint $table) {
			$table->foreign('service_id')->references('id')->on('services')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('option_translations', function(Blueprint $table) {
			$table->foreign('option_id')->references('id')->on('options')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
	}

	public function down()
	{
		Schema::table('users', function(Blueprint $table) {
			$table->dropForeign('users_tier_id_foreign');
		});
		Schema::table('addresses', function(Blueprint $table) {
			$table->dropForeign('addresses_user_id_foreign');
		});
		Schema::table('reviews', function(Blueprint $table) {
			$table->dropForeign('reviews_user_id_foreign');
		});
		Schema::table('favourites', function(Blueprint $table) {
			$table->dropForeign('favourites_user_id_foreign');
		});
		Schema::table('search_histories', function(Blueprint $table) {
			$table->dropForeign('search_histories_user_id_foreign');
		});
		Schema::table('countries', function(Blueprint $table) {
			$table->dropForeign('countries_currency_id_foreign');
		});
		Schema::table('country_translations', function(Blueprint $table) {
			$table->dropForeign('country_translations_country_id_foreign');
		});
		Schema::table('currency_translations', function(Blueprint $table) {
			$table->dropForeign('currency_translations_currency_id_foreign');
		});
		Schema::table('devices', function(Blueprint $table) {
			$table->dropForeign('devices_user_id_foreign');
		});
		Schema::table('subsections', function(Blueprint $table) {
			$table->dropForeign('subsections_section_id_foreign');
		});
		Schema::table('coupons', function(Blueprint $table) {
			$table->dropForeign('coupons_store_id_foreign');
		});
		Schema::table('coupon_users', function(Blueprint $table) {
			$table->dropForeign('coupon_users_coupon_id_foreign');
		});
		Schema::table('coupon_users', function(Blueprint $table) {
			$table->dropForeign('coupon_users_user_id_foreign');
		});
		Schema::table('orders', function(Blueprint $table) {
			$table->dropForeign('orders_offer_id_foreign');
		});
		Schema::table('orders', function(Blueprint $table) {
			$table->dropForeign('orders_driver_id_foreign');
		});
		Schema::table('orders', function(Blueprint $table) {
			$table->dropForeign('orders_user_id_foreign');
		});
		Schema::table('orders', function(Blueprint $table) {
			$table->dropForeign('orders_default_currency_id_foreign');
		});
		Schema::table('orders', function(Blueprint $table) {
			$table->dropForeign('orders_from_address_foreign');
		});
		Schema::table('orders', function(Blueprint $table) {
			$table->dropForeign('orders_to_address_foreign');
		});
		Schema::table('orders', function(Blueprint $table) {
			$table->dropForeign('orders_address_id_foreign');
		});
		Schema::table('orders', function(Blueprint $table) {
			$table->dropForeign('orders_coupon_id_foreign');
		});
		Schema::table('order_items', function(Blueprint $table) {
			$table->dropForeign('order_items_order_id_foreign');
		});
		Schema::table('order_items', function(Blueprint $table) {
			$table->dropForeign('order_items_item_id_foreign');
		});
		Schema::table('order_items', function(Blueprint $table) {
			$table->dropForeign('order_items_size_id_foreign');
		});
		Schema::table('order_items', function(Blueprint $table) {
			$table->dropForeign('order_items_option_id_foreign');
		});
		Schema::table('order_items', function(Blueprint $table) {
			$table->dropForeign('order_items_preference_id_foreign');
		});
		Schema::table('carts', function(Blueprint $table) {
			$table->dropForeign('carts_item_id_foreign');
		});
		Schema::table('carts', function(Blueprint $table) {
			$table->dropForeign('carts_user_id_foreign');
		});
		Schema::table('carts', function(Blueprint $table) {
			$table->dropForeign('carts_size_id_foreign');
		});
		Schema::table('carts', function(Blueprint $table) {
			$table->dropForeign('carts_preference_id_foreign');
		});
		Schema::table('carts', function(Blueprint $table) {
			$table->dropForeign('carts_option_id_foreign');
		});
		Schema::table('carts', function(Blueprint $table) {
			$table->dropForeign('carts_gift_id_foreign');
		});
		Schema::table('punchcards', function(Blueprint $table) {
			$table->dropForeign('punchcards_user_id_foreign');
		});
		Schema::table('notifications', function(Blueprint $table) {
			$table->dropForeign('notifications_user_id_foreign');
		});
		Schema::table('tier_translations', function(Blueprint $table) {
			$table->dropForeign('tier_translations_tier_id_foreign');
		});
		Schema::table('providers', function(Blueprint $table) {
			$table->dropForeign('providers_user_id_foreign');
		});
		Schema::table('status_translations', function(Blueprint $table) {
			$table->dropForeign('status_translations_status_id_foreign');
		});
		Schema::table('order_statuses', function(Blueprint $table) {
			$table->dropForeign('order_statuses_order_id_foreign');
		});
		Schema::table('order_statuses', function(Blueprint $table) {
			$table->dropForeign('order_statuses_status_id_foreign');
		});
		Schema::table('section_translations', function(Blueprint $table) {
			$table->dropForeign('section_translations_section_id_foreign');
		});
		Schema::table('subsection_translations', function(Blueprint $table) {
			$table->dropForeign('subsection_translations_sub_section_id_foreign');
		});
		Schema::table('stores', function(Blueprint $table) {
			$table->dropForeign('stores_default_currency_id_foreign');
		});
		Schema::table('stores', function(Blueprint $table) {
			$table->dropForeign('stores_to_currency_id_foreign');
		});
		Schema::table('stores', function(Blueprint $table) {
			$table->dropForeign('stores_admin_id_foreign');
		});
		Schema::table('stores', function(Blueprint $table) {
			$table->dropForeign('stores_sub_section_id_foreign');
		});
		Schema::table('store_translations', function(Blueprint $table) {
			$table->dropForeign('store_translations_store_id_foreign');
		});
		Schema::table('point_users', function(Blueprint $table) {
			$table->dropForeign('point_users_user_id_foreign');
		});
		Schema::table('point_stores', function(Blueprint $table) {
			$table->dropForeign('point_stores_store_id_foreign');
		});
		Schema::table('offers', function(Blueprint $table) {
			$table->dropForeign('offers_store_id_foreign');
		});
		Schema::table('offers', function(Blueprint $table) {
			$table->dropForeign('offers_tier_id_foreign');
		});
		Schema::table('offer_users', function(Blueprint $table) {
			$table->dropForeign('offer_users_offer_id_foreign');
		});
		Schema::table('offer_users', function(Blueprint $table) {
			$table->dropForeign('offer_users_user_id_foreign');
		});
		Schema::table('store_categories', function(Blueprint $table) {
			$table->dropForeign('store_categories_store_id_foreign');
		});
		Schema::table('store_category_translations', function(Blueprint $table) {
			$table->dropForeign('store_category_translations_store_category_id_foreign');
		});
		Schema::table('drink_translations', function(Blueprint $table) {
			$table->dropForeign('drink_translations_drink_id_foreign');
		});
		Schema::table('ingredients', function(Blueprint $table) {
			$table->dropForeign('ingredients_item_id_foreign');
		});
		Schema::table('items', function(Blueprint $table) {
			$table->dropForeign('items_category_id_foreign');
		});
		Schema::table('items', function(Blueprint $table) {
			$table->dropForeign('items_store_id_foreign');
		});
		Schema::table('items', function(Blueprint $table) {
			$table->dropForeign('items_default_currency_id_foreign');
		});
		Schema::table('Item_translations', function(Blueprint $table) {
			$table->dropForeign('Item_translations_item_id_foreign');
		});
		Schema::table('ingredient_translations', function(Blueprint $table) {
			$table->dropForeign('ingredient_translations_ingredient_id_foreign');
		});
		Schema::table('item_addons', function(Blueprint $table) {
			$table->dropForeign('item_addons_item_id_foreign');
		});
		Schema::table('item_addons', function(Blueprint $table) {
			$table->dropForeign('item_addons_addon_id_foreign');
		});
		Schema::table('item_drinks', function(Blueprint $table) {
			$table->dropForeign('item_drinks_item_id_foreign');
		});
		Schema::table('item_drinks', function(Blueprint $table) {
			$table->dropForeign('item_drinks_drink_id_foreign');
		});
		Schema::table('offer_tanslations', function(Blueprint $table) {
			$table->dropForeign('offer_tanslations_offer_id_foreign');
		});
		Schema::table('sides', function(Blueprint $table) {
			$table->dropForeign('sides_item_id_foreign');
		});
		Schema::table('side_translations', function(Blueprint $table) {
			$table->dropForeign('side_translations_side_id_foreign');
		});
		Schema::table('sizes', function(Blueprint $table) {
			$table->dropForeign('sizes_item_id_foreign');
		});
		Schema::table('size_translations', function(Blueprint $table) {
			$table->dropForeign('size_translations_size_id_foreign');
		});
		Schema::table('item_gifts', function(Blueprint $table) {
			$table->dropForeign('item_gifts_item_id_foreign');
		});
		Schema::table('wallets', function(Blueprint $table) {
			$table->dropForeign('wallets_user_id_foreign');
		});
		Schema::table('wallets', function(Blueprint $table) {
			$table->dropForeign('wallets_primary_currency_id_foreign');
		});
		Schema::table('options', function(Blueprint $table) {
			$table->dropForeign('options_item_id_foreign');
		});
		Schema::table('preferences', function(Blueprint $table) {
			$table->dropForeign('preferences_item_id_foreign');
		});
		Schema::table('services', function(Blueprint $table) {
			$table->dropForeign('services_item_id_foreign');
		});
		Schema::table('preference_translations', function(Blueprint $table) {
			$table->dropForeign('preference_translations_preference_id_foreign');
		});
		Schema::table('service_translations', function(Blueprint $table) {
			$table->dropForeign('service_translations_service_id_foreign');
		});
		Schema::table('option_translations', function(Blueprint $table) {
			$table->dropForeign('option_translations_option_id_foreign');
		});
	}
}
