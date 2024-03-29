<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

            <div class="block-header">
                <h2><?php echo $pageTitle;?></h2>
            </div>
           
            <div class="row clearfix">
                <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                    <div class="card">
                        <div class="header bg-green">
                            <h2>Foto Profil</h2>
                        </div>
                        <div class="body">
                            <img src="<?php echo $mhs->foto;?>" class="img-responsive img-thumbnail"/>
                        </div>
                    </div>
                </div>

                <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-green">
                            <h2>
                                <?php echo $mhs->nama;?> <small>Source: Database Akademik Unsrat</small>
                            </h2>
                        </div>
                        <div class="body">
                            <dl class="dl-horizontal">
                                <dt>NIM</dt>
                                <dd><?php echo $mhs->nim; ?>&nbsp;</dd>
                                <dt>Alamat</dt>
                                <dd><?php echo $mhs->alamat; ?>&nbsp;</dd>
                                <dt>Tempat Tanggal Lahir</dt>
                                <dd><?php echo $mhs->tempatLahir." ".$mhs->tanggalLahir; ?>&nbsp;</dd>                                  
                                <dt>Jenis Kelamin</dt>
                                <dd><?php echo $mhs->jenisKelamin; ?>&nbsp;</dd>
                                <dt>Agama</dt>
                                <dd><?php echo $mhs->agama; ?>&nbsp;</dd>
                                <dt>Status Nikah</dt>
                                <dd><?php echo $mhs->statusNikah; ?>&nbsp;</dd>                        
                                <dt>Angkatan</dt>
                                <dd><?php echo $mhs->angkatan; ?>&nbsp;</dd>
                                <dt>Jalur Masuk</dt>
                                <dd><?php echo $mhs->jalurMasuk; ?>&nbsp;</dd>
                                <dt>Sumber Dana</dt>
                                <dd><?php echo $mhs->sumberDana; ?>&nbsp;</dd>                                                            
                                <dt>Fakultas</dt>
                                <dd><?php echo $mhs->fakultas; ?>&nbsp;</dd>
                                <dt>Jurusan</dt>
                                <dd><?php echo $mhs->jurusan; ?>&nbsp;</dd>                                  
                                <dt>Program Studi</dt>
                                <dd><?php echo $mhs->prodi; ?>&nbsp;</dd>
                                <dt>Pembimbing Akademik</dt>
                                <dd><?php echo $mhs->dosenPembimbingAkademik;?>&nbsp;</dd>
                                <dt>Status Mahasiswa</dt>
                                <dd><?php echo $mhs->statusMahasiswa; ?>&nbsp;</dd>
                                <dt>Hobi</dt>
                                <dd><?php echo $mhs->hobi; ?>&nbsp;</dd>
                                <dt>No Hp</dt>
                                <dd><?php echo $mhs->noHp; ?>&nbsp;</dd>
                                <dt>Email</dt>
                                <dd><?php echo $mhs->email; ?>&nbsp;</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>