<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0 text-dark"><?php echo $block_header ?></h5>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="col-12">
                                <?php echo $alert; ?>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <h5>
                                        <?php echo strtoupper($header) ?>
                                        <p class="text-secondary"><small><?php echo $sub_header ?></small></p>
                                    </h5>
                                </div>
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-2"></div>
                                        <div class="col-10">
                                            <div class="float-right">
                                                <?php echo (isset( $header_button )) ? $header_button : '';  ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo form_open($url); ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row mb-3">
                                        <div class="col-12">                                        
                                            <div class="form-group">
                                                <label for="">Tanggal</label>
                                                <div class="form-input">
                                                    <input type="hidden" name="date" value="<?php echo date('d-m-Y') ?>">
                                                    <?php echo date('d-m-Y') ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-lg-3 col-md-7 col-sm-12">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label>Aktivitas</label>
                                                        <select class="form-control" name="type_id" id="type_id">
                                                            <option value="">-- Pilih Aktivitas --</option>
                                                            <?php foreach ($activities_types as $key => $activities_type) { ?>
                                                                <option value="<?= $activities_type->id ?>"><?= $activities_type->name ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label>Nama Aktivitas</label>
                                            <select class="form-control" style="width: 100%;" name="activity_id" id="activity_id">
                                                <option value="">-- Pilih Aktivitas --</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="">Hasil</label>
                                                <div class="form-input">
                                                    <input type="number" name="result" id="result" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <div class="row">                                            
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="">Waktu Mulai</label>
                                                        <div class="input-group date" id="input_start_time" data-target-input="nearest">
                                                            <input type="text" name="start_time" id="start_time" class="form-control datetimepicker-input" data-target="#input_start_time"/>
                                                            <div class="input-group-append" data-target="#input_start_time" data-toggle="datetimepicker">
                                                                <div class="input-group-text"><i class="far fa-clock"></i></div>
                                                            </div>
                                                        </div>
                                                    </div>    
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="">Waktu Selesai</label>
                                                        <div class="input-group date" id="input_end_time" data-target-input="nearest">
                                                            <input type="text" name="end_time" id="end_time" class="form-control datetimepicker-input" data-target="#input_end_time"/>
                                                            <div class="input-group-append" data-target="#input_end_time" data-toggle="datetimepicker">
                                                                <div class="input-group-text"><i class="far fa-clock"></i></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="">Keterangan</label>
                                                <div class="form-input">
                                                    <textarea name="description" id="description" class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer float-right">
                            <button type="submit" class="btn btn-sm btn-success">Tambah Aktivitas</button>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Kalender Aktivitas</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3 col-md-5 col-sm-12">
                                    <div class="card-primary card card-outline">
                                        <div class="card-body">                                        
                                            <?php 
                                                foreach ($activities_states as $key => $activities_state) {
                                            ?>
                                                <div class="col-12">
                                                    <button class="btn btn-sm btn-block m-1" style="background-color: #<?= $activities_state->color ?>"><?= $activities_state->name ?></button>
                                                </div>
                                            <?php   
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-9 col-md-7 col-sm-12">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>