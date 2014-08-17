<style type="text/css">
@import
    url("http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,400italic")
    ;

@import url("//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.css");

body {
    padding: 60px 0px;
    background-color: rgb(220, 220, 220);
}

.event-list {
    list-style: none;
    font-family: 'Lato', sans-serif;
    margin: 0px;
    padding: 0px;
}

.event-list>li {
    background-color: rgb(255, 255, 255);
    box-shadow: 0px 0px 5px rgb(51, 51, 51);
    box-shadow: 0px 0px 5px rgba(51, 51, 51, 0.7);
    padding: 0px;
    margin: 0px 0px 20px;
}

.event-list>li>time {
    display: inline-block;
    width: 100%;
    color: rgb(255, 255, 255);
    background-color: rgb(197, 44, 102);
    padding: 5px;
    text-align: center;
    text-transform: uppercase;
}

.event-list>li:nth-child(even)>time {
    background-color: rgb(165, 82, 167);
}

.event-list>li>time>span {
    display: none;
}

.event-list>li>time>.day {
    display: block;
    font-size: 56pt;
    font-weight: 100;
    line-height: 1;
}

.event-list>li time>.month {
    display: block;
    font-size: 24pt;
    font-weight: 900;
    line-height: 1;
}

.event-list>li>img {
    width: 100%;
}

.event-list>li>.info {
    padding-top: 5px;
    text-align: center;
}

.event-list>li>.info>.title {
    font-size: 15pt;
    font-weight: 700;
    margin: 0px;
}

.event-list>li>.info>.desc {
    font-size: 11pt;
    font-weight: 300;
    margin: 0px;
}

.event-list>li>.info>.address {
    font-size: 10pt;
    font-weight: 300;
    margin: 0px;
}

.event-list>li>.info>ul, .event-list>li>.social>ul {
    display: table;
    list-style: none;
    margin: 10px 0px 0px;
    padding: 0px;
    width: 100%;
    text-align: center;
}

.event-list>li>.social>ul {
    margin: 0px;
}

.event-list>li>.info>ul>li, .event-list>li>.social>ul>li {
    display: table-cell;
    cursor: pointer;
    color: rgb(30, 30, 30);
    font-size: 11pt;
    font-weight: 300;
    padding: 3px 0px;
}

.event-list>li>.info>ul>li>a {
    display: block;
    width: 100%;
    color: rgb(30, 30, 30);
    text-decoration: none;
}

.event-list>li>.social>ul>li {
    padding: 0px;
}

.event-list>li>.social>ul>li>a {
    padding: 3px 0px;
}

.event-list>li>.info>ul>li:hover, .event-list>li>.social>ul>li:hover {
    color: rgb(30, 30, 30);
    background-color: rgb(200, 200, 200);
}

.facebook a, .twitter a, .google-plus a {
    display: block;
    width: 100%;
    color: rgb(75, 110, 168) !important;
}

.twitter a {
    color: rgb(79, 213, 248) !important;
}

.google-plus a {
    color: rgb(221, 75, 57) !important;
}

.facebook:hover a {
    color: rgb(255, 255, 255) !important;
    background-color: rgb(75, 110, 168) !important;
}

.twitter:hover a {
    color: rgb(255, 255, 255) !important;
    background-color: rgb(79, 213, 248) !important;
}

.google-plus:hover a {
    color: rgb(255, 255, 255) !important;
    background-color: rgb(221, 75, 57) !important;
}

@media ( min-width : 768px) {
    .event-list>li {
        position: relative;
        display: block;
        width: 100%;
        height: 120px; /* 120px; */
        padding: 0px;
    }
    .event-list>li>time, .event-list>li>img {
        display: inline-block;
    }
    .event-list>li>time, .event-list>li>img {
        width: 120px;
        float: left;
    }
    .event-list>li>.info {
        background-color: rgb(245, 245, 245);
        overflow: hidden;
    }
    .event-list>li>time, .event-list>li>img {
        width: 120px;
        height: 120px; /* 120px; */
        padding: 0px;
        margin: 0px;
    }
    .event-list>li>.info {
        position: relative;
        height: 120px; /* 120px; */
        text-align: left;
        padding-right: 40px;
    }
    .event-list>li>.info>.title, .event-list>li>.info>.desc {
        padding: 0px 3px;
    }
    .event-list>li>.info>ul {
        position: absolute;
        left: 0px;
        bottom: 0px;
    }
    .event-list>li>.social {
        position: absolute;
        top: 0px;
        right: 0px;
        display: block;
        width: 40px;
    }
    .event-list>li>.social>ul {
        border-left: 1px solid rgb(230, 230, 230);
    }
    .event-list>li>.social>ul>li {
        display: block;
        padding: 0px;
    }
    .event-list>li>.social>ul>li>a {
        display: block;
        width: 40px;
        padding: 10px 0px 9px;
    }
}
            </style>

            <div class="container">
                <div class="row">

<?php               foreach ($listEvent as $eventItem ) { ?>
<?php
                        $eventTitle         = strlen($eventItem['event_title']) < 30 ? $eventItem['event_title'] : substr($eventItem['event_title'], 0, 30) . "...";
                        $eventDescription   = strlen($eventItem['event_description']) < 39 ? $eventItem['event_description'] : substr($eventItem['event_title'], 0, 39) . "...";
?>

                        <div class="col-sm-6">
                            <ul class="event-list">
                                <li class="col-sm-4"><time datetime="<?php echo  CHtml::encode($eventItem['event_start_date']); ?>">
                                        <span class="day"><?php echo date("j", strtotime($eventItem['event_start_date'])); ?></span> <span class="month"><?php echo date("M", strtotime($eventItem['event_start_date'])); ?></span>
                                        <span class="year">2014</span> <span class="time">ALL
                                            DAY</span>
                                    </time> <img alt="<?php echo CHtml::encode($eventTitle); ?>"
                                    src="<?php echo  CHtml::encode($eventItem['event_photo']); ?>" />
                                    <div class="info">
                                        <h2 class="title"><?php echo CHtml::encode($eventTitle); ?></h2>
                                        <p class="desc"><?php echo  CHtml::encode($eventDescription); ?></p>
                                        <p class="address"><?php echo  CHtml::encode($eventItem['event_address1']); ?></p>
                							<ul>
                								<li style="width:50%;"><a href="#website"><span class="fa fa-globe"></span> Website</a></li>
                								<li style="width:50%;"><span class="fa fa-money"></span> $ <?php echo  CHtml::encode($eventItem['cost']); ?></li>
                							</ul>
                                    </div>
    <!--
                                    <div class="social">
                                        <ul>
                                            <li class="facebook" style="width: 33%;"><a
                                                href="#facebook"><span class="fa fa-facebook"></span></a></li>
                                            <li class="twitter" style="width: 34%;"><a
                                                href="#twitter"><span class="fa fa-twitter"></span></a></li>
                                            <li class="google-plus" style="width: 33%;"><a
                                                href="#google-plus"><span
                                                    class="fa fa-google-plus"></span></a></li>
                                        </ul>
                                    </div>
                                </li>
    -->
                            </ul>
                        </div>
<?php               } ?>
                </div>
            </div>
<!-- COUNTRY ITEM -->



