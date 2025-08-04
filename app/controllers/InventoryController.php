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
        $data = [
            'title' => 'Inventory',
            'inventory' => Inventory::all()
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

    // Handle item creation
    public function store(Request $request)
    {
        // Validate form inputs
        $items = $request->validate([
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
        $items['item_image'] = $image ? $image->store('public/storage/items-img') : null;

        // Save to database
        if (Inventory::insert($items)) {
            setSweetAlert('success', 'Added!', 'New item saved successfully.');
            redirect('/admin/inventory');
        } else {
            setSweetAlert('error', 'Oops!', 'Couldn’t save the item. Try again.');
            redirect('/admin/inventory');
        }
    }

    /**
     * Show a single inventory item
     */
    public function show($id)
    {
        $inventory = Inventory::find($id);

        if (!$inventory) {
            setSweetAlert('error', 'Oops!', 'Item not found.');
            redirect('/admin/inventory');
        }

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
        $data = [
            'title' => 'Edit Inventory',
            'inventory' => Inventory::find($id)
        ];

        return $this->view('admin/inventory/update', $data);
    }

    /**
     * Handle item update
     */
    public function update(Request $request, $id)
    {
        // Validate update inputs
        $items = $request->validate([
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
        $existing = Inventory::find($id);

        // Handle image upload if a new image is provided
        $image = FileHandler::fromRequest('item_image');

        if ($image) {
            // delete the old image if exist
            if (!empty($existing->item_image)) {
                FileHandler::delete('public/storage/items-img/', $existing->item_image);
            }
            // Store the new image
            $items['item_image'] = $image->store('public/storage/items-img');
        } else {
            // keep the old image
            $items['item_image'] = $existing->item_image;
        }

        // Update in database
        if (Inventory::update($id, $items)) {
            setSweetAlert('success', 'Updated!', 'Item info has been updated.');
        } else {
            setSweetAlert('error', 'Oops!', 'Couldn’t update the item.');
        }

        return redirect('/admin/inventory');
    }

    /**
     * Show the delete confirmation page
     */
    public function delete($id)
    {
        $data = [
            'title' => 'Delete Item',
            'inventory' => Inventory::find($id)
        ];

        return $this->view('/admin/inventory/delete', $data);
    }

    /**
     * Handle the actual deletion
     */
    public function destroy($id)
    {
        // Find the inventory item by ID
        $item = Inventory::find($id);

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
}
