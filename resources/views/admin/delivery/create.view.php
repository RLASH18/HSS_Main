<form action="/admin/delivery/store" method="post">
    <?= csrf_token() ?>

    <div>
        <label for="order_input">Order ID</label>
        <input type="text" name="order_id" id="order_input" list="order_list" placeholder="Select">
        <datalist id="order_list">
            <?php foreach ($orders as $order): ?>
                <option value="<?= $order->id ?>">
                    Order #<?= $order->user_id ?> - <?= $order->user->name ?>
                </option>
            <?php endforeach ?>
        </datalist>
    </div>

    <div>
        <label for="delivery_method">Delivery method</label>
        <select name="delivery_method" id="delivery_method">
            <option value="pickup">Pickup</option>
            <option value="delivery">Delivery</option>
        </select>
    </div>

    <input type="hidden" name="status" value="scheduled">

    <div>
        <label for="scheduled_date">Scheduled date</label>
        <input type="date" id="scheduled_date" name="scheduled_date">
    </div>

    <label for="remarks">Remarks</label>
    <textarea name="remarks" id="remarks"></textarea>

    <div>
        <label for="driver_name">Driver Name</label>
        <input type="text" id="driver_name" name="driver_name" placeholder="Enter driver's name">
    </div>

    <div>
        <button type="submit">Add delivery</button>
    </div>
</form>