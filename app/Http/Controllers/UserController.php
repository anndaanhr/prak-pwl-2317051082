<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\UserModel;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    public $userModel;
    public $kelasModel;

    public function index(){
        $users = $this->userModel->getUser();
        
        // Dekripsi nama_kelas untuk setiap user
        foreach($users as $user) {
            if($user->nama_kelas) {
                try {
                    $user->nama_kelas = Crypt::decryptString($user->nama_kelas);
                } catch (\Exception $e) {
                    // Jika gagal dekripsi, gunakan nilai asli (untuk backward compatibility)
                    $user->nama_kelas = $user->nama_kelas;
                }
            }
        }
        
        $data = [
            'title' => 'List User',
            'user' => $users
        ];
        return view('list_user', $data);
    }

    public function table(){
        $users = $this->userModel->getUser();
        
        // Dekripsi nama_kelas untuk setiap user
        foreach($users as $user) {
            if($user->nama_kelas) {
                try {
                    $user->nama_kelas = Crypt::decryptString($user->nama_kelas);
                } catch (\Exception $e) {
                    // Jika gagal dekripsi, gunakan nilai asli (untuk backward compatibility)
                    $user->nama_kelas = $user->nama_kelas;
                }
            }
        }
        
        $data = [
            'title' => 'List User - Table View',
            'user' => $users
        ];
        return view('list_user_table', $data);
    }

    public function __construct(){
        $this->userModel = new UserModel();
        $this->kelasModel = new Kelas();
    }

    public function create(){
        $kelasModel = new Kelas();
        $kelas = $kelasModel->getKelas();
        
        // Dekripsi nama_kelas untuk setiap kelas
        foreach($kelas as $kelasItem) {
            if($kelasItem->nama_kelas) {
                try {
                    $kelasItem->nama_kelas = Crypt::decryptString($kelasItem->nama_kelas);
                } catch (\Exception $e) {
                    // Jika gagal dekripsi, gunakan nilai asli (untuk backward compatibility)
                    $kelasItem->nama_kelas = $kelasItem->nama_kelas;
                }
            }
        }
        
        $data = [
            'title' => 'Create User',
            'kelas' => $kelas
        ];

        return view('user_create',$data);
    }

    public function store(Request $request){
        $request->validate([
            'nama' => 'required|string|max:150',
            'npm' => 'required|string|max:20|unique:user,npm',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $this->userModel->create([
            'nama' => $request->input('nama'),
            'npm' => $request->input('npm'),
            'kelas_id' => $request->input('kelas_id'),
        ]);
        return redirect()->to('/user')->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = $this->userModel->findOrFail($id);
        $kelas = $this->kelasModel->getKelas();
        
        // Dekripsi nama_kelas untuk setiap kelas
        foreach($kelas as $kelasItem) {
            if($kelasItem->nama_kelas) {
                try {
                    $kelasItem->nama_kelas = Crypt::decryptString($kelasItem->nama_kelas);
                } catch (\Exception $e) {
                    // Jika gagal dekripsi, gunakan nilai asli (untuk backward compatibility)
                    $kelasItem->nama_kelas = $kelasItem->nama_kelas;
                }
            }
        }
        
        $data = [
            'title' => 'Edit User',
            'user' => $user,
            'kelas' => $kelas
        ];
        return view('edit_user', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:150',
            'npm' => 'required|string|max:20|unique:user,npm,' . $id,
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $user = $this->userModel->findOrFail($id);
        $user->update([
            'nama' => $request->input('nama'),
            'npm' => $request->input('npm'),
            'kelas_id' => $request->input('kelas_id'),
        ]);

        return redirect()->route('user.index')->with('success', 'User berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = $this->userModel->findOrFail($id);
        $user->delete();

        return redirect()->route('user.index')->with('success', 'User berhasil dihapus!');
    }
}
