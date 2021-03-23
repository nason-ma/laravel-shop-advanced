<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProductsAddCategoryId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable()->after('id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // dropForeign() 删除外键关联，要早于 dropColumn() 删除字段调用，否则数据库会报错。
            // dropForeign() 方法的参数可以是字符串也可以是一个数组，如果是字符串则代表删除外键名为该字符串的外键，
            // 而如果是数组的话则会删除该数组中字段所对应的外键。我们这个 category_id 字段默认的外键名是 products_category_id_foreign，因此需要通过数组的方式来删除。
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
}
