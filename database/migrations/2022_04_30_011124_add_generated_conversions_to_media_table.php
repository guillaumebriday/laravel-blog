<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasColumn('media', 'generated_conversions')) {
            Schema::table('media', function (Blueprint $table) {
                $table->json('generated_conversions')->nullable();
            });
        }

        Media::query()
            ->where(function ($query) {
                $query->whereNull('generated_conversions')
                    ->orWhere('generated_conversions', '')
                    ->orWhereRaw("JSON_TYPE(generated_conversions) = 'NULL'");
            })
            ->whereRaw("JSON_LENGTH(custom_properties) > 0")
            ->update([
                'generated_conversions' => DB::raw('custom_properties->"$.generated_conversions"'),
                // OPTIONAL: Remove the generated conversions from the custom_properties field as well:
                // 'custom_properties'     => DB::raw("JSON_REMOVE(custom_properties, '$.generated_conversions')")
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /* Restore the 'generated_conversions' field in the 'custom_properties' column if you removed them in this migration
        Media::query()
                ->whereRaw("JSON_TYPE(generated_conversions) != 'NULL'")
                ->update([
                    'custom_properties' => DB::raw("JSON_SET(custom_properties, '$.generated_conversions', generated_conversions)")
                ]);
        */

        Schema::table('media', function (Blueprint $table) {
            $table->dropColumn('generated_conversions');
        });
    }
};
