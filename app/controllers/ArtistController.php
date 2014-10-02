<?php
class ArtistController extends BaseController {

  public function getArtists() {
    return View::make('artist');
  }

  public function getSingleArtist() {

  }

  public function getAddArtist() {
    return View::make('artists.add');
  }

  public function postAddArtist() {

  }

  public function getEditArtist() {

  }

  public function postEditArtist() {

  }

}