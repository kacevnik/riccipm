	<!-- FOOTER -->
	<footer class="main_footer">
	<div class="container">
<!-- INSTAGRAM SECTION-->
<div class="row">
	<div class="instagramm_wrapper">
		<img src="/wp-content/themes/s-a-ricci/img/project/instagram.png" alt="instagram">
		<h3>Последние публикации</h3>
		<a class="ins_btn" target="_blank" href="https://instagram.com/sariccipm">instagram.com/sariccipm</a>
		<div class="instagramm_module_wrapper">
		<?php	dynamic_sidebar('instagram_section'); ?>	
		</div>
	</div>
</div>
<!-- COPYRIGHT SECTION-->
<div class="row">
	<div class="copyright_wrapper">
		<span>© «S.A.Ricci Project Management» 2012 — <?php echo date('Y') ?></span>
		<span><a class="konf" href="/politika-konfedicialnosti/">Политика конфедициальности</a></span>	
		
			<?php	dynamic_sidebar('footer_section'); ?>	
	</div>
</div>

<!-- End CODE-->

<!-- popup -->
<div style="display: none;max-width:600px;" id="politica">
<?php	dynamic_sidebar('popup_section'); ?>	
</div>


	</div>
</footer>

<!-- Yandex.Metrika counter -->
<script>
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter42178749 = new Ya.Metrika({
                    id:42178749,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true,
                    trackHash:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>


<!-- Yandex.Metrika counter -->
<script>
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(42178749, "init", {
        id:42178749,
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true,
        trackHash:true
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/42178749" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->


<noscript><div><img src="https://mc.yandex.ru/watch/42178749" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-90560698-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-90560698-1');
</script>

<!-- Подключение скриптов js вынесено в functions.php-->
<?php wp_footer(); ?> 
</body>
</html>




