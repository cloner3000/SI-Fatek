<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

                    <li class="header">DAFTAR MENU</li>
                    <li>
                        <a href="<?php echo site_url('jurusan/dashboard');?>">
                            <i class="material-icons">dashboard</i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('admin/data/mahasiswa/angkatan/'.(date('Y')-4));?>">
                            <i class="material-icons">people</i>
                            <span>Data Mahasiswa</span>
                        </a>
                    </li>                   
                    <li>
                        <a href="<?php echo site_url('jurusan/data/alumni');?>">
                            <i class="material-icons">school</i>
                            <span>Data Alumni</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('jurusan/data/dosen');?>">
                            <i class="material-icons">local_library</i>
                            <span>Data Dosen</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('admin/dokumen');?>">
                            <i class="material-icons">library_books</i>
                            <span>Repositori Jurusan</span>
                        </a>
                    </li>
                    <li class="header">AKADEMIK</li>