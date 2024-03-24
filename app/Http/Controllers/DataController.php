<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Data;

class DataController extends Controller
{
    //get data
    public function getData()
    {
        $data = Data::all(); // Fetch data from database 
        return response()->json($data);
    }

    // Insert data
    public function insertData(Request $request)
    {
        // Validate request data
        $validatedData = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'date' => 'required|date',
        ]);

        // Create new data instance
        $data = new Data();
        $data->title = $validatedData['title'];
        $data->content = $validatedData['content'];
        $data->date = $validatedData['date'];
        $data->save();

        return response()->json(['message' => 'Data inserted successfully', 'data' => $data], 201);
    }

    //update data
    public function update(Request $request, $id)
    {
        $data = Data::findOrFail($id);
        
        // Validate request data if necessary
        $validatedData = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'date' => 'required|date',
        ]);
        
        // Update data
        $data->update($validatedData);

        return response()->json(['message' => 'Data updated successfully', 'data' => $data], 200);
    }


    // Delete data
    public function delete($id)
    {
        $data = Data::findOrFail($id);
        
        // Delete data
        $data->delete();

        return response()->json(['message' => 'Data deleted successfully'], 200);
    }
}
