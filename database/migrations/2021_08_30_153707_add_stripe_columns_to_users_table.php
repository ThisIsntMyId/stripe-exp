<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStripeColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('stripe_id')->nullable()->index();
            $table->string('address_line_1')->nullable()->index();
            $table->string('address_line_2')->nullable()->index();
            $table->string('address_state')->nullable()->index();
            $table->string('address_city')->nullable()->index();
            $table->string('address_zipcode')->nullable()->index();

            // $table->string('pm_type')->nullable();
            // $table->string('pm_last_four', 4)->nullable();
            // $table->timestamp('trial_ends_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'stripe_id',
                'address_line_1',
                'address_line_2',
                'address_state',
                'address_city',
                'address_zipcode'
                // 'pm_type',
                // 'pm_last_four',
                // 'trial_ends_at',
            ]);
        });
    }
}
