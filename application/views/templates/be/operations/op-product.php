<div class="text-center">
    <ul class="icons-list">
        <li class="text-primary-600">
            <a href="<?= base_url('admin/shop/editProduct/' . $row['id']); ?>"
               title="ویرایش" data-popup="tooltip">
                <i class="icon-pencil7"></i>
            </a>
        </li>
        <li class="text-danger-600">
            <a class="deleteProductBtn"
               title="حذف" data-popup="tooltip">
                <input type="hidden"
                       value="<?= $row['id']; ?>">
                <i class="icon-trash"></i>
            </a>
        </li>
    </ul>
</div>