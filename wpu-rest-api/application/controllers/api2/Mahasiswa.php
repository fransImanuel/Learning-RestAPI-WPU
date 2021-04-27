<?php
defined('BASEPATH') or exit('No direct script access allowed');


use chriskacerguis\RestServer\RestController;

class Mahasiswa extends RestController{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mahasiswa_model', 'mahasiswa');
    }
    
    public function index_get(){
        $id = $this->get('id');
        if($id == null){
            $mahasiswa = $this->mahasiswa->getMahasiswa();
        }else{
            $mahasiswa = $this->mahasiswa->getMahasiswa($id);
        }        
        
        if($mahasiswa){
            // Set the response and exit
            $this->response([
                'status' => true,
                'data' => $mahasiswa
            ], RestController::HTTP_OK);
        }else{
            $this->response([
                'status' => false,
                'data' => 'Id Not Found'
            ], RestController::HTTP_NOT_FOUND);
        }
    }

    public function index_delete(){
        $id = $this->delete('id');

        if($id === null){
            $this->response([
                'status' => false,
                'data' => 'Provide an Id'
            ], RestController::HTTP_BAD_REQUEST);
        }else{
            if( $this->mahasiswa->deleteMahasiswa($id) > 0 ){
                //ok
                $this->response([
                    'status' => true,
                    'id' => $id,
                    'message' => 'deleted.'
                ], RestController::HTTP_OK);

            }else{
                //id not found
                $this->response([
                    'status' => false,
                    'data' => 'Id Not Found'
                ], RestController::HTTP_NOT_FOUND);
            }
        }
    }

    public function index_post(){
        $data =  [
            'nrp' => $this->post('nrp'),
            'nama' => $this->post('nama'),
            'email' => $this->post('email'),
            'jurusan' => $this->post('jurusan')
        ];

        if( $this->mahasiswa->createMahasiswa($data) > 0 ){
            $this->response([
                'status' => true,
                'message' => 'New Mahasiswa Has Been Created'
            ], RestController::HTTP_CREATED);
        }else{
            //id not found
            $this->response([
                'status' => false,
                'message' => 'Failed to create new data'
            ], RestController::HTTP_NOT_FOUND);
        }
    }

    public function index_put(){
        $id = $this->put('id');
        $data =  [
            'nrp' => $this->put('nrp'),
            'nama' => $this->put('nama'),
            'email' => $this->put('email'),
            'jurusan' => $this->put('jurusan')
        ];

        if ( $this->mahasiswa->updateMahasiswa($data, $id) > 0 ) {
            $this->response([
                'status' => true,
                'message' => 'Data Mahasiswa Has Been Updated'
            ], RestController::HTTP_OK);
        } else {
            //id not found
            $this->response([
                'status' => false,
                'message' => 'Failed to update data'
            ], RestController::HTTP_BAD_REQUEST);
        }
    }

}