<div id="pay-win" <? if ($_GET[act]=='pay') { echo 'style="display:block"'; } ?>>
    <div id="pay-block">
        <div class="close"></div>

        <!-- ! -->
        <form method="POST" class="pay-line" style="border-top:none" action="/pay/form.php">
            <div class="price">3600 руб. &nbsp;/&nbsp; <span>за 360 дней</span> <p>Старая цена: 4500 руб.</p></div>
            <div class="bonus">+ 72 дня бесплатно</div>
            <div class="button">
                <input type="hidden" name="summ" value="3600" />
                <input type="submit" value="Оплатить" />
            </div>
        </form>
        <!-- End ! -->

        <!-- ! -->
        <form method="POST" class="pay-line" action="/pay/form.php">
            <div class="price hit">1800 руб. &nbsp;/&nbsp; <span>за 180 дней</span> <p>Старая цена: 2700 руб.</p></div>
            <div class="bonus">+ 36 дней бесплатно</div>
            <div class="button">
                <input type="hidden" name="summ" value="1800" />
                <input type="submit" value="Оплатить" />
            </div>
        </form>
        <!-- End ! -->

        <!-- ! -->
        <form method="POST" class="pay-line" action="/pay/form.php">
            <div class="price">900 руб. &nbsp;/&nbsp; <span>за 90 дней</span> <p>Старая цена: 1500 руб.</p></div>
            <div class="bonus">+ 18 дней бесплатно</div>
            <div class="button">
                <input type="hidden" name="summ" value="900" />
                <input type="submit" value="Оплатить" />
            </div>
        </form>
        <!-- End ! -->

        <!-- ! -->
        <form method="POST" class="pay-line" action="/pay/form.php">
            <div class="price">600 руб. &nbsp;/&nbsp; <span>за 60 дней</span> <p>Старая цена: 1100 руб.</p></div>
            <div class="bonus">+ 12 дней бесплатно</div>
            <div class="button">
                <input type="hidden" name="summ" value="600" />
                <input type="submit" value="Оплатить" />
            </div>
        </form>
        <!-- End ! -->

        <!-- ! -->
        <form method="POST" class="pay-line" action="/pay/form.php">
            <div class="price">300 руб. &nbsp;/&nbsp; <span>за 30 дней</span> <p>Старая цена: 550 руб.</p></div>
            <div class="bonus"></div>
            <div class="button">
                <input type="hidden" name="summ" value="300" />
                <input type="submit" value="Оплатить" />
            </div>
        </form>
        <!-- End ! -->

        <div id="payment">
            <p>Мгновенная оплата. Принимаем все популярные виды платежей:</p>
            <img src="images/pays.png" width="438" height="33" />
        </div>
    </div>
</div>