<?php

namespace app\controllers;

use app\core\Controller;
use app\core\FileHandler;
use app\core\Request;
use app\models\Inventory;

class InventoryController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Inventory',
            'inventory' => Inventory::all()
        ];

        return $this->view('admin/inventory/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Add Item'
        ];

        return $this->view('admin/inventory/create', $data);
    }

    public function store(Request $request)
    {
        if ($request->isPost()) {

            // validate
            $items = $request->validate([
                'supplier_name' => 'required',
                'item_name' => 'required',
                'description' => 'nullable',
                'category' => 'required',
                'image' => 'nullable|image',
                'unit_price' => 'required',
                'quantity' => 'required',
                'restock_threshold' => 'required'
            ]);

            // image upload
            $image = FileHandler::fromRequest('image');
            $items['image'] = $image ? $image->store('public/storage/items-img') : null;

            // insert
            if (Inventory::insert($items)) {
                setSweetAlert('success', 'Success!', 'Item has been added successfully.');
                redirect('/admin/inventory');
            } else {
                setSweetAlert('error', 'Error!', 'Something went wrong. Please try again.');
                redirect('/admin/inventory');
            }
        }
    }

    public function show($id)
    {
        $data = [
            'title' => 'Inventory Item',
            'inventory' => Inventory::find($id)
        ];

        return $this->view('admin/inventory/show', $data);
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Inventory',
            'inventory' => Inventory::find($id)
        ];

        return $this->view('admin/inventory/update', $data);
    }

    public function update(Request $request, $id)
    {
        $items = $request->validate([
            'supplier_name' => 'required',
            'item_name' => 'required',
            'description' => 'nullable',
            'category' => 'required',
            'image' => 'nullable',
            'unit_price' => 'required',
            'quantity' => 'required',
            'restock_threshold' => 'required'
        ]);

        if (Inventory::update($id, $items)) {
            setSweetAlert('success', 'Success!', 'Item updated successfully.');
        } else {
            setSweetAlert('error', 'Error!', 'Something went wrong. Please try again.');
        }

        return redirect('/admin/inventory');
    }

    public function delete($id)
    {
        $data = [
            'title' => 'Delete Item',
            'inventory' => Inventory::find($id)
        ];

        return $this->view('/admin/inventory/delete', $data);
    }

    public function destroy($id)
    {
        if (Inventory::delete($id)) {
            setSweetAlert('success', 'Success!', 'Item deleted successfully.');
        } else {
            setSweetAlert('error', 'Error!', 'Failed to delete item.');
        }

        redirect('/admin/inventory');
    }
}
