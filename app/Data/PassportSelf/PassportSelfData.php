<?php
namespace App\Data\PassportSelf;

use App\Models\PassportSelf;
use Illuminate\Http\Request;


class PassportSelfData{

    protected $request;

    public function __construct(Request $request = null){
        $this->request = $request;
    }

    public function find($id){
        return PassportSelf::find($id);
    }

    public function list(){
        
        return PassportSelf::orderBy('name', 'desc')->get();
    }

    public function store(){

        PassportSelf::create([
            'name' => $this->request->name
        ]);

    }


    public function destroy($id){

        PassportSelf::where('id', $id)->delete();

    }
}