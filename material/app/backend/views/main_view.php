<style>
  .bigger-image {
    max-width: 100%;
    /* Максимальная ширина изображения будет равна ширине его контейнера */
    height: auto;
    /* Сохранение соотношения сторон, чтобы изображение не искажалось */
    display: block;
    /* Убедитесь, что изображение правильно отображается как блочный элемент */
    margin: auto;
    /* Центрирование изображения */
    max-height: 100%;
  }
</style>
<div class="app-title text-center" style="justify-content: center;">
  <div>
    <section class="hero container-fluid text-center">
      <h2>Добро пожаловать на сайт научных достижений!</h2>
      <p>Узнайте о последних научных открытиях и инновациях, которые меняют наш мир.</p>
      <a href="#" class="btn btn-primary">Узнать больше</a>
    </section>

    <section class="features container mt-5">
      <div class="row">
        <div class="col-md-4">
          <img src="/app/uploads/file/biotechnology.jpg" alt="Биотехнологии" class="img-fluid bigger-image">
          <h3>Биотехнологии</h3>
          <p>Исследования в области биотехнологий, здравоохранения и медицины.</p>
        </div>
        <div class="col-md-4">
          <img src="/app/uploads/file/ecology.jpg" alt="Экология" class="img-fluid bigger-image">
          <h3>Экология</h3>
          <p>Изучение влияния человечества на окружающую среду и разработка экологически устойчивых решений.</p>
        </div>
        <div class="col-md-4">
          <img src="/app/uploads/file/ai.jpg" alt="Искусственный интеллект" class="img-fluid bigger-image">
          <h3>Искусственный интеллект</h3>
          <p>Развитие и исследование методов искусственного интеллекта и машинного обучения.</p>
        </div>
      </div>
    </section>
    <br/>
    <div class="row" style="justify-content:center;">
      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <h3>Открытие нового метода лечения рака</h3>
            <p>Наше исследование выявило эффективность нового метода лечения рака, основанного на иммунотерапии.</p>
          </div>
          <div class="carousel-item">
            <h3>Разработка уникального материала для солнечных батарей</h3>
            <p>Мы создали новый материал, обладающий высокой эффективностью преобразования солнечной энергии в
              электричество.</p>
          </div>
          <div class="carousel-item">
            <h3>Понимание механизмов старения клеток</h3>
            <p>Наши исследования помогли раскрыть основные механизмы старения клеток, что может привести к разработке
              новых методов борьбы со старением.</p>
          </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>

    <footer class="container-fluid text-center mt-5">
      <p>&copy; 2024 Сайт научных достижений. Все права защищены.</p>
    </footer>
  </div>
</div>


<script src="/assets/plugins/jquery-3.2.1.min.js"></script>
<script src="/assets/plugins/popper.min.js"></script>
<script src="/assets/plugins/bootstrap.min.js"></script>