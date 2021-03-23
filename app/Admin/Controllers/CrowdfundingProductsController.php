<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use App\Models\CrowdfundingProduct;
use App\Models\Product;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Grid\Displayers\Actions;
use Encore\Admin\Grid\Tools;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class CrowdfundingProductsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Product';

    public function index(Content $content)
    {
        return $content->header('众筹商品列表')
            ->body($this->grid());
    }

    public function edit($id, Content $content)
    {
        return $content
            ->header('编辑众筹商品')
            ->body($this->form()->edit($id));
    }

    public function create(Content $content)
    {
        return $content
            ->header('创建众筹商品')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Product());

        $grid->model()->where('type', Product::TYPE_CROWDFUNDING);
        $grid->column('id', __('ID'))->sortable();
        // $grid->column('type', __('Type'));
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
        // $grid->column('category_id', __('Category id'));
        // $grid->column('description', __('Description'));
        // $grid->column('rating', __('Rating'));
        // $grid->column('sold_count', __('Sold count'));
        // $grid->column('review_count', __('Review count'));
        // $grid->column('created_at', __('Created at'));
        // $grid->column('updated_at', __('Updated at'));

        $grid->actions(function (Actions $actions) {
            // 不在每一行展示查看按钮
            $actions->disableView();
            // 不在每一行展示删除按钮
            $actions->disableDelete();
        });
        $grid->tools(function (Tools $tools) {
            // 禁用批量删除按钮
            $tools->batch(function ($batch) {
                $batch->disableDelete();
            });
        });

        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Product());

        // 在表单中添加一个名为 type，值为 Product::TYPE_CROWDFUNDING 的隐藏字段
        $form->hidden('type')->value(Product::TYPE_CROWDFUNDING);
        $form->text('title', __('商品名称'))->rules('required');
        $form->select('category_id', '类目')->options(function ($id) {
            $category = Category::find($id);
            if ($category) {
                return [$category->id => $category->full_name];
            }
        })->ajax('/admin/api/categories?is_directory=0');
        // 创建一个选择图片的框
        $form->image('image', __('封面图片'))->rules('required|image');
        // 创建一个富文本编辑器， 富文本编辑组件在v1.7.0版本之后移除
        $form->ueditor('description', __('商品描述'))->rules('required');
        // 创建一组单选框
        $form->radio('on_sale', __('上架'))->options(['1' => '是', '0' => '否'])->default('0');
        // 添加众筹相关字段
        $form->text('crowdfunding.target_amount', '众筹目标金额')->rules('required|numeric|min:0.01');
        $form->datetime('crowdfunding.end_at', '众筹结束时间')->rules('required|date');
        $form->hasMany('skus', '商品 SKU', function (Form\NestedForm $form) {
            $form->text('title', 'SKU 名称')->rules('required');
            $form->text('description', 'SKU 描述')->rules('required');
            $form->text('price', '单价')->rules('required|numeric|min:0.01');
            $form->text('stock', '剩余库存')->rules('required|integer|min:0');
        });
        $form->saving(function (Form $form) {
            $form->model()->price = collect($form->input('skus'))->where(Form::REMOVE_FLAG_NAME, 0)->min('price');
        });

        return $form;
    }
}
