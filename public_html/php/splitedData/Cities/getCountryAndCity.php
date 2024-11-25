<?php

function getAllCity($connect){
    $cityQuery = mysqli_query($connect, "select * from CityName");
    $cities = [];
    while($city = mysqli_fetch_assoc($cityQuery)){
        $cities[] = $city;
    }

    return $cities;
}

function getAllRegions($connect){
    $regionQuery = mysqli_query($connect, "select * from RegionsName");
    $regions = [];
    while($region = mysqli_fetch_assoc($regionQuery)){
        $regions[] = $region;
    }
    return $regions;
}