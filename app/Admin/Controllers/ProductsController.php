<?php

namespace App\Admin\Controllers;

use App\Models\Product;
use Encore\Admin\Form;
use Encore\Admin\Grid;

class ProductsController extends CommonProductsController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Product';

    public function getProductType()
    {
        return Product::TYPE_NORMAL;
    }

    protected function customGrid(Grid $grid)
    {
        $grid->model()->with(['category']);
        $grid->column('id', __('ID'))->sortable();
        // lightbox 可点击图片放大进行查看
        $grid->column('image', __('封面图'))->lightbox(['width' => 50, 'height' => 50]);
        $grid->column('title', __('商品名称'));
        // Laravel-Admin 支持用符号 . 来展示关联关系的字段
        $grid->column('category.name', __('类目'));
        $grid->column('on_sale', __('已上架'))->display(function ($value) {
            return $value ? '是' : '否';
        });
        $grid->column('price', __('价格'));
        $grid->column('rating', __('评分'));
        $grid->column('sold_count', __('销量'));
        $grid->column('review_count', __('评论数'));
        $grid->column('created_at', __('添加时间'));
    }

    protected function customForm(Form $form)
    {
        // TODO: 普通商品暂无额外的字段，因此这里暂不需写任何代码
    }
}
