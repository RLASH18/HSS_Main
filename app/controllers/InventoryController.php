<?php

namespace app\controllers;

use app\core\Controller;
use app\core\FileHandler;
use app\core\Request;
use app\models\Inventory;

class InventoryController extends Controller
{
    /**
     * Display all inventory items
     */
    public function index()
    {
        $inventory = Inventory::all();

        $data = [
            'title' => 'Inventory',
            'inventory' => $inventory
        ];

        return $this->view('admin/inventory/index', $data);
    }

    /**
     * Show the add item form
     */
    public function create()
    {
        return $this->view('admin/inventory/create', [
            'title' => 'Add Item'
        ]);
    }

    /**
     * Handle item creation
     */
    public function store(Request $request)
    {
        // Validate form inputs
        $inventory = $request->validate([
            'supplier_name' => 'required',
            'item_name' => 'required',
            'description' => 'nullable',
            'category' => 'required',
            'item_image' => 'nullable|image',
            'unit_price' => 'required',
            'quantity' => 'required',
            'restock_threshold' => 'required'
        ]);

        // Handle image upload
        $image = FileHandler::fromRequest('item_image');
        $inventory['item_image'] = $image ? $image->store('public/storage/items-img') : null;

        // Save to database
        if (Inventory::insert($inventory)) {
            setSweetAlert('success', 'Added!', 'New item saved successfully.');
        } else {
            setSweetAlert('error', 'Oops!', 'Couldn’t save the item. Try again.');
        }

        redirect('/admin/inventory');
    }

    /**
     * Show a single inventory item
     */
    public function show($id)
    {
        $inventory = $this->findInventoryOrFail($id);

        $data = [
            'title' => 'Inventory Item',
            'inventory' => $inventory
        ];

        return $this->view('admin/inventory/show', $data);
    }

    /**
     * Show the edit form for an item
     */
    public function edit($id)
    {
        $inventory = $this->findInventoryOrFail($id);

        $data = [
            'title' => 'Edit Inventory',
            'inventory' => $inventory
        ];

        return $this->view('admin/inventory/update', $data);
    }

    /**
     * Handle item update
     */
    public function update(Request $request, $id)
    {
        // Validate update inputs
        $inventory = $request->validate([
            'supplier_name' => 'required',
            'item_name' => 'required',
            'description' => 'nullable',
            'category' => 'required',
            'item_image' => 'nullable',
            'unit_price' => 'required',
            'quantity' => 'required',
            'restock_threshold' => 'required'
        ]);

        // Get existing inventory record
        $existing = $this->findInventoryOrFail($id);

        // Handle image upload if a new image is provided
        $image = FileHandler::fromRequest('item_image');

        if ($image) {
            // delete the old image if exist
            if (!empty($existing->item_image)) {
                FileHandler::delete('public/storage/items-img/', $existing->item_image);
            }
            // Store the new image
            $inventory['item_image'] = $image->store('public/storage/items-img');
        } else {
            // keep the old image
            $inventory['item_image'] = $existing->item_image;
        }

        // Update in database
        if (Inventory::update($id, $inventory)) {
            setSweetAlert('success', 'Updated!', 'Item info has been updated.');
        } else {
            setSweetAlert('error', 'Oops!', 'Couldn’t update the item.');
        }

        redirect('/admin/inventory');
    }

    /**
     * Show the delete confirmation page
     */
    public function delete($id)
    {
        $inventory = $this->findInventoryOrFail($id);

        $data = [
            'title' => 'Delete Item',
            'inventory' => $inventory
        ];

        return $this->view('/admin/inventory/delete', $data);
    }

    /**
     * Handle the actual deletion
     */
    public function destroy($id)
    {
        $item = $this->findInventoryOrFail($id);

        // If item exists and has an image, delete the image file
        if (!empty($item->item_image)) {
            FileHandler::delete('public/storage/items-img/', $item->item_image);
        }

        // Delete the inventory record from the database
        if (Inventory::delete($id)) {
            setSweetAlert('success', 'Deleted!', 'Item removed from inventory.');
        } else {
            setSweetAlert('error', 'Oops!', 'Failed to remove the item.');
        }

        redirect('/admin/inventory');
    }

    /**
     * Finds inventory by ID or redirects with an error if not found
     */
    private function findInventoryOrFail($id)
    {
        $inventory = Inventory::find($id);

        if (!$inventory) {
            setSweetAlert('error', 'Oops!', 'Item not found.');
            redirect('/admin/inventory');
        }

        return $inventory;
    }
}
