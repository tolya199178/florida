<style>
<!--
#dashboard {
    background:#fff;
}
-->
</style>

<style>
<!--
/* Breadcrumbs */
/** The Magic **/
.btn-breadcrumb .btn:not(:last-child):after {
  content: " ";
  display: block;
  width: 0;
  height: 0;
  border-top: 17px solid transparent;
  border-bottom: 17px solid transparent;
  border-left: 10px solid white;
  position: absolute;
  top: 50%;
  margin-top: -17px;
  left: 100%;
  z-index: 3;
}
.btn-breadcrumb .btn:not(:last-child):before {
  content: " ";
  display: block;
  width: 0;
  height: 0;
  border-top: 17px solid transparent;
  border-bottom: 17px solid transparent;
  border-left: 10px solid rgb(173, 173, 173);
  position: absolute;
  top: 50%;
  margin-top: -17px;
  margin-left: 1px;
  left: 100%;
  z-index: 3;
}

/** The Spacing **/
.btn-breadcrumb .btn {
  padding:6px 12px 6px 24px;
}
.btn-breadcrumb .btn:first-child {
  padding:6px 6px 6px 10px;
}
.btn-breadcrumb .btn:last-child {
  padding:6px 18px 6px 24px;
}

/** Default button **/
.btn-breadcrumb .btn.btn-default:not(:last-child):after {
  border-left: 10px solid #fff;
}
.btn-breadcrumb .btn.btn-default:not(:last-child):before {
  border-left: 10px solid #ccc;
}
.btn-breadcrumb .btn.btn-default:hover:not(:last-child):after {
  border-left: 10px solid #ebebeb;
}
.btn-breadcrumb .btn.btn-default:hover:not(:last-child):before {
  border-left: 10px solid #adadad;
}

/** Primary button **/
.btn-breadcrumb .btn.btn-primary:not(:last-child):after {
  border-left: 10px solid #428bca;
}
.btn-breadcrumb .btn.btn-primary:not(:last-child):before {
  border-left: 10px solid #357ebd;
}
.btn-breadcrumb .btn.btn-primary:hover:not(:last-child):after {
  border-left: 10px solid #3276b1;
}
.btn-breadcrumb .btn.btn-primary:hover:not(:last-child):before {
  border-left: 10px solid #285e8e;
}

/** Success button **/
.btn-breadcrumb .btn.btn-success:not(:last-child):after {
  border-left: 10px solid #5cb85c;
}
.btn-breadcrumb .btn.btn-success:not(:last-child):before {
  border-left: 10px solid #4cae4c;
}
.btn-breadcrumb .btn.btn-success:hover:not(:last-child):after {
  border-left: 10px solid #47a447;
}
.btn-breadcrumb .btn.btn-success:hover:not(:last-child):before {
  border-left: 10px solid #398439;
}

/** Danger button **/
.btn-breadcrumb .btn.btn-danger:not(:last-child):after {
  border-left: 10px solid #d9534f;
}
.btn-breadcrumb .btn.btn-danger:not(:last-child):before {
  border-left: 10px solid #d43f3a;
}
.btn-breadcrumb .btn.btn-danger:hover:not(:last-child):after {
  border-left: 10px solid #d2322d;
}
.btn-breadcrumb .btn.btn-danger:hover:not(:last-child):before {
  border-left: 10px solid #ac2925;
}

/** Warning button **/
.btn-breadcrumb .btn.btn-warning:not(:last-child):after {
  border-left: 10px solid #f0ad4e;
}
.btn-breadcrumb .btn.btn-warning:not(:last-child):before {
  border-left: 10px solid #eea236;
}
.btn-breadcrumb .btn.btn-warning:hover:not(:last-child):after {
  border-left: 10px solid #ed9c28;
}
.btn-breadcrumb .btn.btn-warning:hover:not(:last-child):before {
  border-left: 10px solid #d58512;
}


-->
</style>

        <!-- Breadcrumbs -->
        <div id="breadcrumbs">

            <div class="container">

                <div class='row'>
                    <div class="col-sm-12">
                        <br/>

                        <div class="panel panel-default">
                          <div class="panel-body">

                               <div class="navbar-text">

                                    <div class="btn-group btn-breadcrumb">
                                        <a href="#" class="btn btn-default"><i class="glyphicon glyphicon-home"></i>Home</a>
                                        <a href="#" class="btn btn-default">Discussions</a>
                                    </div>

                               </div>
                               <div>
                                  <p class="navbar-text navbar-right">
                                    <a href="#" class="btn btn-success"><i class="glyphicon glyphicon-question-sign"></i>&nbsp;&nbsp;Ask a Question.</a>
                                  </p>
                               </div>

                          </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
        <!-- ./Breadcrumbs -->

        <div id="dashboard">



            <div class="container">

                <div class="row">
                    <div class="col-sm-12">
                        <ul class="nav nav-tabs" id="myTab">
                            <li class="active"><a href="#questions" data-toggle="tab">Questions</a></li>
                            <li><a href="#rants" data-toggle="tab">Rants</a></li>
                            <li><a href="#raves" data-toggle="tab">Raves</a></li>
                        </ul>
                    </div>


                    <!-- col-12-->
                    <div class="col-sm-12">

                        <div class="panel panel-default">
                          <div class="panel-body">

                                <div class="tab-content">

                                    <div class="tab-pane active" id="questions">

                                        <?php $this->renderPartial("dashboard/components/questions",array('data' => $data)); ?>

                                    </div>

                                    <!--/tab-pane-->


                                    <div class="tab-pane" id="rants">

                                        <?php $this->renderPartial("dashboard/components/rants",array('data' => $data)); ?>

                                    </div>
                                    <!--/tab-pane-->

                                    <div class="tab-pane" id="raves">
                                        <?php $this->renderPartial("dashboard/components/raves",array('data' => $data)); ?>

                                    </div>
                                </div>

                          </div>
                        </div>

                </div>
                <!--/col-9-->
            </div>


            </div>

        </div>



