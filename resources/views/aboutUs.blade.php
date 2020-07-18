@extends('layouts.app')

@section('content')

	<article>
		<div class="container-fluid">
			<div class="page_header row justify-content-center">
				<div class="col-lg-10 col-md-12 col-sm-12 p-15">
					<h1 class="page_header">О нас</h1>
				</div>
				<div class="about_us_text col-lg-10 col-md-12 col-sm-12">
					<p>Мы предлагаем широкий ассортимент строительных материалов. Анализ текущей рыночной ситуации позволяет нам понимать какие 
					материалы востребованы, а работа с производителями - реализовывать пожелания клиентов. </p> <p>Мы осуществляем оптовую 
					и розничную продажу строительных материалов различных видов: монтажная пена, силикон, электрика, сантехника и многое другое.</p>
					<div id="shop_images">
						<ul>
							<li><img class="detail_img" src="/img/shop-images/shop-picture (1).jpg" alt=""></li>
							<li><img class="detail_img" src="/img/shop-images/shop-picture (2).jpg" alt=""></li>
							<li><img class="detail_img" src="/img/shop-images/shop-picture (3).jpg" alt=""></li>
							<li><img class="detail_img" src="/img/shop-images/shop-picture (4).jpg" alt=""></li>
							<li><img class="detail_img" src="/img/shop-images/shop-picture (5).jpg" alt=""></li>
							<li><img class="detail_img" src="/img/shop-images/shop-picture (6).jpg" alt=""></li>
							<li><img class="detail_img" src="/img/shop-images/shop-picture (7).jpg" alt=""></li>
							<li><img class="detail_img" src="/img/shop-images/shop-picture (8).jpg" alt=""></li>
							<li><img class="detail_img" src="/img/shop-images/shop-picture (9).jpg" alt=""></li>
							<li><img class="detail_img" src="/img/shop-images/shop-picture (10).jpg" alt=""></li>
							<li><img class="detail_img" src="/img/shop-images/shop-picture (11).jpg" alt=""></li>
							<li><img class="detail_img" src="/img/shop-images/shop-picture (12).jpg" alt=""></li>
						</ul>
					</div>
					<p><strong>Лучшие материалы-гибкий подход.</strong></p>
					<p>Это наш девиз, так что же это значит?</p>
					<p>Мы предоставляет широкий выбор строительных материалов. Лучшие - из возможных на рынке и в соответствии с требованиями заказчиков. 
					Гибкий подход - подбор товара, цен в соответствии с пожеланиями клиентов. Быстрое реагирование и предложение вариантов замены, 
					если, например, товара в наличии нет или срок поставки слишком велик.</p>
					<p><strong>Основные принципы:</strong></p>
					<p>честность - мы всегда сообщаем о характеристиках и свойствах, сообщаем об отсутствии или наличии товаров и 
					наших сложностях;</p>
					<p>обязательства - мы всегда выполняем наши обязательства;</p>
					<p>конфиденциальность - мы не рассказываем о наших клиентах, поставщиках, партнерах коммерческую информацию;</p>
					<p>прибыльность - мы держим определенный уровень цен, работаем для получения прибыли для обеспечения высокого уровня обслуживания 
					наших клиентов;</p>
					<p>гибкость - мы предоставляем широкий ассортимент и готовы изменять его в соответствии с запросами наших клиентов;</p>
					<p>Миссия - Экономить время клиентов;</p> 
					<p>С нами работают: </p> <p> Наши реквизиты:........</p>
					</p>
				</div>
			</div>
		</div>
	</article>
	<div class="modal fade" id="detail_img" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="col-12 p-0">
					<img class="modal_image img-fluid" src="/img/shop-images/shop-picture (1).jpg" alt="">
				</div>
			</div>
			</div>
		</div>
	</div>
@endsection