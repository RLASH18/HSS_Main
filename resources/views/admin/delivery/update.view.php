<?php layout('admin/header') ?>

<form action="/admin/delivery/update/<?= $deliveries->id ?>" method="post">
    <?= csrf_token() ?>

    <div>
        <label for="order_input">Order ID</label>
        <input type="text" name="order_id" id="order_input" list="order_list" placeholder="Select Order ID" value="<?= $deliveries->order_id ?>" <?= isInvalid('order_id') ?>>
        <datalist id="order_list">
            <?php foreach ($orders as $order): ?>
                <option value="<?= $order->id ?>">
                    Order #<?= $order->user_id ?> - <?= $order->user->name ?>
                </option>
            <?php endforeach ?>
        </datalist>
        <p class="mt-1 text-sm text-red-500"><?= error('order_id') ?></p>
    </div>

    <div>
        <label for="delivery_method">Delivery method</label>
        <select name="delivery_method" id="delivery_method" <?= isInvalid('delivery_method')?>>
            <option value="pickup" <?= $deliveries->delivery_method === 'pickup' ? 'selected' : '' ?> >Pickup</option>
            <option value="delivery" <?= $deliveries->delivery_method === 'delivery' ? 'selected' : '' ?>  >Delivery</option>
        </select>
        <p class="mt-1 text-sm text-red-500"><?= error('delivery_method') ?></p>
    </div>

    <input type="hidden" name="status" value="scheduled">

    <div>
        <label for="scheduled_date">Scheduled date</label>
        <input type="date" id="scheduled_date" name="scheduled_date" value="<?= $deliveries->scheduled_date ?>" <?= isInvalid('scheduled_date')?>>
        <p class="mt-1 text-sm text-red-500"><?= error('scheduled_date') ?></p>
    </div>

    <div>
        <label for="remarks">Remarks</label>
        <textarea name="remarks" id="remarks" <?= isInvalid('remarks')?>><?= $deliveries->remarks ?></textarea>
        <p class="mt-1 text-sm text-red-500"><?= error('remarks') ?></p>
    </div>

    <div>
        <label for="driver_name">Driver Name</label>
        <input type="text" id="driver_name" name="driver_name" value="<?= $deliveries->driver_name ?>" <?= isInvalid('driver_name')?>>
        <p class="mt-1 text-sm text-red-500"><?= error('driver_name') ?></p>
    </div>

    <div>
        <button type="submit">Add delivery</button>
    </div>
</form>

<?php layout('admin/footer') ?>
