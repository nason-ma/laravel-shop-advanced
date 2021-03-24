<?php

namespace App\Admin\Controllers;

use App\Models\CrowdfundingProduct;
use App\Models\Product;
use Encore\Admin\Form;
use Encore\Admin\Grid;

class CrowdfundingProductsController extends CommonProductsController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Product';

    public function getProductType()
    {
        return Product::TYPE_CROWDFUNDING;
    }

    protected function customGrid(Grid $grid)
    {
        $grid->column('id', __('ID'))->sortable();
        // lightbox 可点击图片放大进行查看
        $grid->column('image', __('封面图'))->lightbox(['width' => 50, 'height' => 50]);
        $grid->column('title', __('商品名称'));
        $grid->column('on_sale', __('已上架'))->display(function ($value) {
            return $value ? '是' : '否';
        });
        $grid->column('price', __('价格'));
        // 展示众筹相关字段
        $grid->column('crowdfunding.target_amount', '目标金额');
        $grid->column('crowdfunding.end_at', '结束时间');
        $grid->column('crowdfunding.total_amount', '目前金额');
        $grid->column('crowdfunding.status', ' 状态')->display(function ($value) {
            return CrowdfundingProduct::$statusMap[$value];
        });
    }

    protected function customForm(Form $form)
    {
        // 添加众筹相关字段
        $form->text('crowdfunding.target_amount', '众筹目标金额')->rules('required|numeric|min:0.01');
        $form->datetime('crowdfunding.end_at', '众筹结束时间')->rules('required|date');
    }
}
