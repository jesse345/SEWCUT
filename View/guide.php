<?php
include("../Model/db.php");
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("../layouts/head.layout.php")?>
    <title>My Product</title>
</head>
<body>
    <?php
    $user = mysqli_fetch_assoc(getrecord('user_details','id',$_SESSION['id']));
    $p = displayDetails('product_details','category','dress');
    ?>
    <div class="page-wrapper">
        <?php include("../layouts/header_layout.php"); ?>
        <main class="main">
            <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
                <div class="container-fluid">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Guide</li>
                    </ol>
                </div><!-- End .container-fluid -->
            </nav><!-- End .breadcrumb-nav -->
            <div class="container">
                <div class="text-center">
                    <h2 class="title">eShakti Size and Fit Guide</h2><br>
                </div>
                <h2 class="title-sm">Design your perfect fit</h2>
                <p>It's easy to get the perfect fit and customize any item that catches your eye at eShakti from hemllines to nechlines to sleeeves, get your favorite outfits customized<br>
                the way you like. </p>
                <p>Our size and fit guide ill help you tto get the right measurement for a freat fit with your made-to-order item that makes you look and feel your best.<br>
                eShakti offers the broadest size range availabl(XS to 6X) for every outfit we have. Choose from our standard sizes or get your outfits made to your exact <br>
                measurement.</p>

                <table class="table table-bordered text-center">
                    <tr>
                        <td rowspan="2">SIZE</td>
                        <td colspan="2" style="width:8%;">XS</td>
                        <td colspan="2" style="width:8%;">S</td>
                        <td colspan="2" style="width:8%;">M</td>
                        <td colspan="2" style="width:8%;">L</td>
                        <td colspan="2" style="width:8%;">XL</td>
                        <td colspan="2" style="width:8%;">1XL</td>
                        <td colspan="2" style="width:8%;">2X</td>
                        <td colspan="2" style="width:8%;">3X</td>
                        <td colspan="2" style="width:8%;">4X</td>
                        <td colspan="2" style="width:8%;">5X</td>
                        <td style="width:8%;">6X</td>
                    </tr>
                    <tr>
                        <td>0</td>
                        <td>2</td>
                        <td>4</td>
                        <td>6</td>
                        <td>8</td>
                        <td>10</td>
                        <td>12</td>
                        <td>14</td>
                        <td>16</td>
                        <td>18</td>
                        <td>16W</td>
                        <td>18W</td>
                        <td>20W</td>
                        <td>22W</td>
                        <td>24W</td>
                        <td>26W</td>
                        <td>28W</td>
                        <td>30W</td>
                        <td>32W</td>
                        <td>34W</td>
                        <td>36W</td>
                    </tr>
                    <tr>
                        <td>Burst</td>
                        <td>32</td>
                        <td>33</td>
                        <td>34</td>
                        <td>35</td>
                        <td>36</td>
                        <td>37</td>
                        <td>38.5</td>
                        <td>40</td>
                        <td>41.5</td>
                        <td>43.5</td>
                        <td>43</td>
                        <td>45</td>
                        <td>47</td>
                        <td>49</td>
                        <td>51</td>
                        <td>53</td>
                        <td>55</td>
                        <td>57</td>
                        <td>60</td>
                        <td>63</td>
                        <td>66</td>
                    </tr>
                    <tr>
                        <td>Natural Waist</td>
                        <td>25</td>
                        <td>26</td>
                        <td>27</td>
                        <td>28</td>
                        <td>29</td>
                        <td>30</td>
                        <td>31.5</td>
                        <td>33</td>
                        <td>34.5</td>
                        <td>36.5</td>
                        <td>36</td>
                        <td>38</td>
                        <td>40</td>
                        <td>42</td>
                        <td>44</td>
                        <td>46</td>
                        <td>48</td>
                        <td>50</td>
                        <td>53</td>
                        <td>56</td>
                        <td>59</td>
                    </tr>
                    <tr>
                        <td>Hip</td>
                        <td>35</td>
                        <td>36</td>
                        <td>37</td>
                        <td>38</td>
                        <td>39</td>
                        <td>40</td>
                        <td>41.5</td>
                        <td>43</td>
                        <td>44.5</td>
                        <td>46.5</td>
                        <td>46</td>
                        <td>48</td>
                        <td>50</td>
                        <td>52</td>
                        <td>54</td>
                        <td>56</td>
                        <td>58</td>
                        <td>60</td>
                        <td>63</td>
                        <td>66</td>
                        <td>69</td>
                    </tr>
                </table>
                <div class="row">
                    <div class="col-4"><br><br>
                        <img src="../images/measurements.png" alt="">
                    </div>
                    <div class="col-8">
                        <h2 class="title-sm">How to measure yourself:</h2>
                        <p>(Write down the measurements in inches)</p><br>
                        <p class="mb-1">Whether you choose to go with standard sizing or custom measurements, please be sure to follow our <br>
                        recommendation on <u>how to measure yourself correctly to ensure your item delights you when it arrives.</u></p>
                        <p>Ensure you measure overt the undergarments you plan to wear when you wear the item. Keep your tape measure
                        level and close, and don't pull it too tight <br>
                        If possibible, have a friend or family member measure you -- It's more accurate !</p>
                        <h2 class="title-sm mb-0 mt-2">Chest or Bust:</h2>
                        <p>This measurement is used for tops and dresses.</p>
                        <p>Women: Place one end of the tape measure at the fullest part of your bust and wrap it around your body to get the  measurement, keeping the tape parallel to the floor.</p>
                        <h2 class="title-sm mb-0 mt-2">Waist:</h2>
                        <p>This measurement is used for tops, dresses, and bottoms.</p>
                        <p>Most clothing lines use the measurement of the “natural waist” for their size guides. To measure your natural waist, you want to find the narrowest part of your waist, located above your belly button and below your rib cage.</p>
                        <p>Note some brands use a “low” waist measurement. For this, you would measure at the point where your trousers would normally ride.</p>
                        <h2 class="title-sm mb-0 mt-2">Hips:</h2>
                        <p>This measurement is used for bottoms and sometimes for dresses.</p>
                        <p>Stand with your hips together and measure the fullest part of your hips. Be sure to go over your buttocks as well. It might be challenging to keep the tape consistently level when you do it alone; it is recommended that you have a friend assist you with this or that you do it in front of a mirror.</p>
                        <h2 class="title-sm mb-0 mt-2"> Inseam:</h2>
                        <p>This measurement is used for trousers and jeans.</p>
                        <p>The inseam is the distance from the uppermost part of your thigh to your ankle. It is easiest to measure the inseam based on a well-fitting pair of pants. Measure from the crotch to the cuff on the inside seam of the leg. The number of inches, to the nearest ½”, is the inseam length. It’s best to measure your inseam with a pair of shoes on so that you can ensure the hem hits at the right point on your shoe.</p>
                        <p>For women, keep in mind that the accurate inseam measurement depends on whether you’re wearing heels or flats. The hem should hit at the middle of the heel shaft or should hit just slightly above the flat shoe. It would be best for women to take two measurements for inseams — one for trousers you’d wear with heels, and one for trousers you’d wear with flats.</p>
                        <h2 class="title-sm mb-0 mt-2"> Neck measurement:</h2>
                        <p>Neck measurement is commonly used for sizing men’s dress shirts. Many dress shirts sold in the U.S. actually use the neck size in inches as the “size.”</p>
                        <p>Wrap the measuring tape around the base of your neck, going around your Adam’s apple. Ensure that the tape is consistently level and that you’re not wrapping the tape too tightly around your neck. This measurement is your true neck measurement. For your dress shirt neck measurement, add a half inch to a round number (i.e. 14 inches should be rounded up to 14.5 inches) or round up to the nearest half inch (i.e. 14.25 should be rounded up to 14.5).</p>
                    </div>
                </div>
                <div class="text-center mt-10">
                    <h2 class="title">Women Measurements Guide</h2>
                    <video src="../images/women.mp4" controls width="1000" height="500">
                        Your browser does not support the video tag.
                    </video>
                </div>
                <div class="text-center mt-5">
                    <h2 class="title">Men Measurements Guide</h2>
                    <video src="../images/men.mp4" controls width="1000" height="500">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>
        </main><!-- End .main -->
        <br>
        <?php include("../layouts/footer.layout1.php"); ?>
    </div>
    <?php include("../layouts/jsfile.layout.php"); ?>
</body>
</html>