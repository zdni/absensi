<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0 text-dark"><?php echo $block_header ?></h5>
                </div>
                <div class="col-6">
                    <div class="row">
                        <div class="col-2"></div>
                        <div class="col-9">
                            <div class="float-right">
                                <?php echo (isset( $header_button )) ? $header_button : '';  ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="timeline">
                        <?php if ( $activity_date ) { ?>
                        <?php foreach ($activity_date as $date => $activities) { ?>
                            <div class="time-label">
                                <span class="bg-blue"><?= $date ?></span>
                            </div>
                            <?php foreach ($activities as $key => $activity) { ?>
                                
                                <div>
                                    <i class="fas fa-clock bg-green"></i>
                                    <div class="timeline-item p-2">
                                        <span class="time"><i class="fas fa-clock"></i> <?= $activity['end_time']; ?></span>
                                        <h4 class="timeline-header no-border">
                                        <?= $activity['describe']; ?>
                                        </h4>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                        <?php } else { ?>
                            <div class="time-label">
                                <span class="bg-blue">dd-mm-YYYY</span>
                            </div>
                            <div>
                                    <i class="fas fa-clock bg-green"></i>
                                    <div class="timeline-item p-2">
                                        <span class="time"><i class="fas fa-clock"></i>--</span>
                                        <h4 class="timeline-header no-border">
                                            Tidak ada Aktivitas
                                        </h4>
                                    </div>
                                </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>