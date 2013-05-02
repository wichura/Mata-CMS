<style>

    #touchstone {
        cursor: default;
        position: absolute;
        top: 20px;
        right: 20px;
        width: 150px;
        background: rgba(55,55,55, 0.8);
        padding: 20px;
        -webkit-border-radius: 5px;
        border-radius: 5px;
        text-align: center;
        color: #FFF;
    }

    #touchstone .highlight {
        font-size: 22px;
    }

    #touchstone-description {
        margin-top: 10px;
        opacity: 0;
        width: 100%;
        left: 0px;
        position: absolute;
        height: 0;
        -webkit-transition: all 0.5s ease;
        -moz-transition: all 0.5s ease;
        -ms-transition: all 0.5s ease;
        -o-transition: all 0.5s ease;
        transition: all 0.5s ease;
    }

    #touchstone-description li {
        padding: 10px 0;
        border-bottom: 1px #FFF solid;
    }
    #touchstone-description li:last-child {
        border-bottom: none;
    }

    #touchstone:hover #touchstone-description {
        opacity: 1;
        position: relative;
        height: auto;
    }

    #touchstone-score {
        margin-bottom: 10px;
    }

</style>


<div onclick="this.style.display = 'none'" id="touchstone">
    <p id="touchstone-score"><span class="highlight"><?php echo $currentScore ?>%</span> complete</p>
    <p>What am I awarded for?</p>
    <div id="touchstone-description">
        <?php echo $scenario->Description ?>
    </div>

</div>