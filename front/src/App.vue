<template>
  <div>
    <div id="map" style="width: 100%;height: 500px;"></div>
    <div>
      <button @clicK="onClickSenkyo">占拠！！！！！</button>
      <button @clicK="syncStation">駅追加</button>
    </div>
  </div>
</template>

<script>
// 遅延読み込みをしているため
/* eslint-disable no-undef */
var scriptjs = require("scriptjs");

const API_URL = "http://d926cfad.ngrok.io";

import axios from "axios";

export default {
  name: "App",
  props: {
    value: {
      type: Boolean,
      default: false
    },
    lat: {
      type: Number,
      default: 34.69704176617222
    },
    lng: {
      type: Number,
      default: 135.5325208455199
    },
    address: {
      type: String,
      default: ""
    }
  },
  data() {
    return {
      map: null,
      mapWidth: window.innerWidth,
      mapHeight: 600,
      defaultSetting: {
        lat: 34.69704176617222,
        lng: 135.5325208455199,
        zoom: 8
      },
      center: null,
      targetMarker: null,
      searchQuery: "",
      stations: [],
      team: "cat"
    };
  },
  created() {
    this.getStations();
    /* eslint-disable no-console */
    console.log("created!!!");
    this.init();
  },
  mounted() {
    /* eslint-disable no-console */
    console.log("mount!!!");
    this.init();
  },
  watch: {},
  methods: {
    init() {
      if (this.address) {
        this.searchQuery = this.address;
      }

      if (this.lat) {
        this.defaultSetting.lat = this.lat;
      }
      if (this.lng) {
        this.defaultSetting.lng = this.lng;
      }

      // すでに google.maps を 読み込んでいる場合は, 読み込みをスキップ
      if (typeof google === "undefined" || typeof google.maps === "undefined") {
        // キャッシュさせないためにqueryを付与
        scriptjs(
          "https://maps.googleapis.com/maps/api/js?key=" +
            "AIzaSyCWC0At8Ol8zFxu4yz5VEKPZmFDOyJKpyw" +
            "&dummy=" +
            new Date().getTime(),
          "loadMap"
        );

        scriptjs.ready("loadMap", () => {
          this.loadMap();
        });

        /* eslint-disable no-console */
        console.log("###");
      } else {
        this.loadMap();
        /* eslint-disable no-console */
        console.log("##ggggg#");
      }
    },
    /**
     * マップを読み込む
     */
    loadMap() {
      // googleMapを初期化
      this.map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: this.defaultSetting.lat, lng: this.defaultSetting.lng },
        zoom: this.defaultSetting.zoom,
        // スワイプ判定を強めに設定
        gestureHandling: "greedy"
      });
    },
    addMyPosition() {
      var flightPlanCoordinates = [
        { lat: 37.772, lng: -122.214 },
        { lat: 21.291, lng: -157.821 },
        { lat: -18.142, lng: 178.431 },
        { lat: -27.467, lng: 153.027 }
      ];
      var flightPath = new google.maps.Polyline({
        path: flightPlanCoordinates,
        geodesic: true,
        strokeColor: "#FF0000",
        strokeOpacity: 1.0,
        strokeWeight: 2
      });

      flightPath.setMap(this.map);
    },
    /**
     * 位置情報取得エラー時callback
     */
    onClickSenkyo() {
      // 緯度経度が渡されなかった場合は現在地検索
      geolocation.getCurrentPosition(
        this.successGeolocationCallback,
        this.errorGeolocationCallback
      );
    },
    /**
     * 位置情報取得success時callback
     */
    successGeolocationCallback() {
      // const lat = position.coords.latitude;
      // const lng = position.coords.longitude;
      // axios.post(`${API_URL}/api/v1/pin`, {
      // }).then(res => {
      // })
    },
    /**
     * 位置情報取得エラー時callback
     */
    errorGeolocationCallback() {
      alert("位置情報を取得できませんでした");
    },
    getStations() {
      axios.get(`${API_URL}/api/v1/stations`).then(res => {
        this.stations = res.data;
        res.data.forEach(station => {
          new google.maps.Marker({
            position: {
              lat: station.lat,
              lng: station.lng
            },
                icon: {
                    url: `./images/svg/train-solid.svg`,
                    scaledSize: new google.maps.Size(15, 15),
                    opacity:0.5,
                },
            map: this.map
          });

          // // クリック時に中心に移動させて店舗をハイライト
          // marker.addListener("click", () => {
          //   this.setPosition(franchises[0].latitude, franchises[0].longitude);
          //   this.highlightMarker(marker, hasEventInSessin);
          // });
          // this.formattedMarkers.push(marker);
        });
      });
    },
    syncStation() {
      console.error("sync!!");
    }
  }
};
</script>
