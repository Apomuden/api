<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalFieldsToBillingSponsorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('billing_sponsors', function (Blueprint $table) {

            $table->unsignedInteger('billing_system_id')->nullable()->after('name');
            $table->foreign('billing_system_id')->references('id')->on('billing_systems')->onDelete('restrict');
            $table->unsignedInteger('billing_cycle_id')->nullable()->after('billing_system_id');
            $table->foreign('billing_cycle_id')->references('id')->on('billing_cycles')->onDelete('restrict');
            $table->unsignedInteger('payment_style_id')->nullable()->after('billing_cycle_id');
            $table->foreign('payment_style_id')->references('id')->on('payment_styles')->onDelete('restrict');
            $table->unsignedInteger('payment_channel_id')->nullable()->after('payment_style_id');
            $table->foreign('payment_channel_id')->references('id')->on('payment_channels')->onDelete('restrict');

            $table->mediumText('address')->after('payment_channel_id')->nullable();
            $table->unsignedBigInteger('active_cell')->after('address');
            $table->unsignedBigInteger('alternate_cell')->after('active_cell')->nullable();
            $table->string('email1')->after('alternate_cell')->nullable();
            $table->string('email2')->after('email1')->nullable();
            $table->string('website')->after('email2')->nullable();
            $table->string('sponsor_code')->after('website')->nullable();

            $table->unsignedInteger('sponsorship_type_id')->nullable()->after('name');
            $table->foreign('sponsorship_type_id')->references('id')->on('sponsorship_types')->onDelete('restrict');

            $table->unique(['name','deleted_at']);
            $table->unique(['email1','deleted_at']);
            $table->unique(['email2','deleted_at']);
            $table->unique(['website','deleted_at']);
            $table->unique(['active_cell','deleted_at']);
            $table->unique(['alternate_cell','deleted_at']);
            $table->unique(['sponsor_code','deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('billing_sponsors', function (Blueprint $table) {

            $table->dropUnique('billing_sponsors_name_deleted_at_unique');
            $table->dropUnique('billing_sponsors_email1_deleted_at_unique');
            $table->dropUnique('billing_sponsors_email2_deleted_at_unique');
            $table->dropUnique('billing_sponsors_website_deleted_at_unique');
            $table->dropUnique('billing_sponsors_active_cell_deleted_at_unique');
            $table->dropUnique('billing_sponsors_alternate_cell_deleted_at_unique');
            $table->dropUnique('billing_sponsors_sponsor_code_deleted_at_unique');

            $table->dropForeign(['billing_system_id']);
            $table->dropForeign(['billing_cycle_id']);
            $table->dropForeign(['payment_style_id']);
            $table->dropForeign(['payment_channel_id']);
            $table->dropForeign(['sponsorship_type_id']);

            $table->dropColumn([
                'billing_system_id',
                'billing_cycle_id',
                'payment_style_id',
                'payment_channel_id',
                'sponsorship_type_id',
                        'address',
                        'active_cell',
                        'alternate_cell',
                        'email1',
                        'email2',
                        'website',
                        'sponsor_code'
                ]);
        });
    }
}
