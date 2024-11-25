<div class="peview-block horizontal-box" >
                    <div class="w-100 horizontal-box">
                        <div class="w-75 h-100 border bg-light rounded-3">
                            <div class="w-100 vertical-box" style="padding-left: 30px; padding-top: 30px;position:relative;">
                                <div class="horizontal-box">
                                    <div id="ads" class="d-flex vertical-align-center horizontal-align-center cursor-pointer preview-page active-page" style="align-self: end;z-index:1;" onclick="showAdsCards()">
                                        Объявления
                                    </div>
                                    <div id="favorites" class="d-flex vertical-align-center horizontal-align-center cursor-pointer preview-page" style="align-self: end;z-index:1;" onclick="showFavoriteCards()">
                                        Избранное
                                    </div>
                                </div>
                                <div  class=" horizontal-box me-5 p-2" style="background-color: #D2D2D2; border-radius: 0 15px 15px 15px; overflow:hidden; overflow-x:auto;">
                                    <div id="my-cards" class="horizontal-box">

                                    </div>
                                </div>
                                <div class="w-100 vertical-align-bottom vertical-box pe-5">
                                    <p class="cursor-pointer" onclick="showAllCardsDialog()" style="padding-bottom: 10px">Показать все</p>
                                </div>

                                <div class="w-100 p-2 vertical-box vertical-align-bottom horizontal-align-center" style="position: absolute; top:0; right:0">
                                        <button class="btn btn-primary" onclick="ShowCreatePetCardDialog()">
                                            Создать объявление
                                        </button>
                                    </div>
                            </div>
                        </div>

                        <div class="w-25 h-100 p-2 bg-light border rounded-3 ms-3">
                            <div class="w-100 h-100 vertical-box">
                                <div>
                                    Сообщества: <?php echo count($communityList);?>
                                </div>
                                <hr class="p-0 m-0">
                                <?php
                                    if(count($communityList) == 0){
                                        echo '<div class="vertical-box w-100 h-100 vertical-align-center horizontal-align-center">
                                        <div style="text-align: center;">
                                            Отсутствуют сообщества
                                        </div>
                                    </div>';
                                    }
                                    foreach ($communityList as $key => $community) {
                                       if($key == 4) break;
                                        $communityName = $community['Name'];
                                        $image = $community['ImageUrl'];
                                        $communitySubId = $community['Id'];
                                    
                                        echo '<div class="p-2">
                                        <div class="w-100 horizontal-box">
                                            <div style="height: 32px; width: 32px"><img src="'.$image.'" alt="" class="w-100 h-100" style="object-fit: cover;"></div>
                                            <div style="text-overflow: ellipsis; overflow: hidden; w-100"><a style="color: black; text-decoration: none;" href="https://animalshub.ru/community?id='.$communitySubId.'">'.$communityName.'</a></div>
                                        </div>
                                    </div>';
                                    }
                                ?>
                                <div class="vertical-box vertical-align-bottom cursor-pointer" onclick="ShowAllCommunityDialog()">
                                    Показать все
                                </div>
                            </div>
                        </div>  
                    </div>
                </div>


            <div class="w-75 mt-3 pe-2">
                <div>
                    <?php include 'php/BlockAddNewNews.php' ?>
                </div>
            </div>