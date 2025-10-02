<template>


<!-- ratings -->

<div class="review-container mb-3 ">



<!-- Title -->
<h2 class="review-title text-center mb-3">Our Happy Customers</h2>


<div class="row">
    <div class="col-md-6">
        <!-- Rating Summary -->
        <div class="rating-summary  text-center">
            <div class="stars">
                <i class="fas fa-star color-custom-orange"></i>
                <i class="fas fa-star color-custom-orange"></i>
                <i class="fas fa-star color-custom-orange"></i>
                <i class="fas fa-star color-custom-orange"></i>
                <i class="fas fa-star color-custom-orange"></i>
            </div>
            <div class="rating-text">
                4.83 out of 5 | 8325 Customer Rating
            </div>

              <!-- Write Review Button -->
<div class="text-center">
    <button class="btn  text-white font-bold bg-custom-orange-dark mb-5">Write A Review</button>
</div>


        </div>
    </div>
    <div class="col-md-6">

<!-- Rating Breakdown -->
<div class="rating-breakdown ps-3">
    <!-- 5 Stars -->
    <div class="rating-row row">
        <div class="col-md-2 col-3   rating-label">5 Stars</div>
        <div class="col-md-7 col-6    progress-wrapper">
            <div class="progress">
                <div class="progress-bar bg-custom-orange-dark" style="width: 83%"></div>
            </div>
        </div>
        <div class="col-3 percentage">83%</div>
    </div>

    <!-- 4 Stars -->
    <div class="rating-row row">
        <div class="col-md-2 col-3 rating-label">4 Stars</div>
        <div class="col-md-7 col-6 progress-wrapper">
            <div class="progress">
                <div class="progress-bar bg-custom-orange-dark" style="width: 17%"></div>
            </div>
        </div>
        <div class="col-3 percentage">17%</div>
    </div>

    <!-- 3 Stars -->
    <div class="rating-row row">
        <div class="col-md-2 col-3 rating-label">3 Stars</div>
        <div class="col-md-7 col-6 progress-wrapper">
            <div class="progress">
                <div class="progress-bar bg-custom-orange-dark" style="width: 0%"></div>
            </div>
        </div>
        <div class="col-3 percentage">0%</div>
    </div>

    <!-- 2 Stars -->
    <div class="rating-row row">
        <div class="col-md-2 col-3 rating-label">2 Stars</div>
        <div class="col-md-7 col-6 progress-wrapper">
            <div class="progress">
                <div class="progress-bar bg-custom-orange-dark" style="width: 0%"></div>
            </div>
        </div>
        <div class="col-3 percentage">0%</div>
    </div>

    <!-- 1 Star -->
    <div class="rating-row row">
        <div class="col-md-2 col-3 rating-label">1 Star</div>
        <div class="col-md-7 col-6 progress-wrapper">
            <div class="progress">
                <div class="progress-bar bg-custom-orange-dark" style="width: 0%"></div>
            </div>
        </div>
        <div class="col-3 percentage">0%</div>
    </div>
</div>
</div>


</div>


<!-- ratings closed -->
</div>



<!-- review card -->

<div class="review-card">
<!-- Top Divider -->
<div class="review-divider"></div>

<div class="row g-4">
    <!-- Left Column - Review Content -->
    <div class="col-12 col-md-8 col-lg-9">
        <div class="d-flex flex-column gap-2 gap-md-3">
            <!-- Star Rating -->
            <div class="star-rating">
                <i class="fas fa-star color-custom-orange"></i>
                <i class="fas fa-star color-custom-orange"></i>
                <i class="fas fa-star color-custom-orange"></i>
                <i class="fas fa-star color-custom-orange"></i>
                <i class="fas fa-star color-custom-orange"></i>
            </div>

            <!-- Review Text -->
            <div>
                <p class="review-text">
                    I have used many branded products but none have given the results that AVG has given. I am very happy with the results of AVG products.
                </p>
            </div>
        </div>
    </div>

    <!-- Right Column - Meta Information -->
    <div class="col-12 col-md-4 col-lg-3">
        <div class="d-flex flex-column justify-content-between h-100 gap-2">
            <!-- Date and Name -->
            <div class="d-flex flex-column gap-1">
                <p class="review-meta mb-0">Submitted 4 months ago</p>
                <p class="review-meta mb-0">By Punam Aniket Mandave</p>
            </div>

            <!-- Verified Badge -->
            <div class="verified-badge">
                <img src="https://www.buywow.in/images/verified.svg"
                     alt="Verified"
                     class="verified-icon">
                <p class="verified-text">VERIFIED BUYER</p>
            </div>
        </div>
    </div>
</div>
</div>


<!-- review card closed-->



</template>

<script>

 export default{
    name: 'ProductReviews',
    props: {
      product: {
        type: Array,
        default: () => []
      },

    },

    data()  {
        return {
            colors: [
        "rgb(203, 237, 243)", // light blue
        "rgb(255, 230, 230)", // light red
        "rgb(230, 255, 230)", // light green
        "rgb(255, 245, 204)", // light yellow
        "rgb(230, 230, 255)", // light purple
        "rgb(255, 240, 245)"  // light pink
      ]


        }
    },
 }
</script>

<style scoped>



.review-card {

border-radius: 12px;
padding: 20px;
margin: 20px 0;

}

.review-divider {
height: 0.5px;
background-color: #343a40;
width: 100%;
margin-bottom: 16px;
}

.star-rating {
display: flex;
gap: 2px;
margin-bottom: 12px;
}

.star-icon {
width: 16px;
height: 16px;
cursor: default;
}

@media (min-width: 768px) {
.star-icon {
    width: 20px;
    height: 20px;
}
}

.review-text {
color: #212529;
font-size: 14px;
line-height: 1.4;
margin-bottom: 0;
}

@media (min-width: 576px) {
.review-text {
    font-size: 14px;
}
}

@media (min-width: 992px) {
.review-text {
    font-size: 16px;
}
}

.review-meta {
color: #212529;
font-size: 12px;
margin-bottom: 4px;
}

@media (min-width: 576px) {
.review-meta {
    font-size: 14px;
}
}

@media (min-width: 992px) {
.review-meta {
    font-size: 16px;
}
}

.verified-badge {
display: flex;
align-items: center;
gap: 4px;
}

.verified-icon {
width: 20px;
height: 20px;
}

@media (min-width: 768px) {
.verified-icon {
    width: 24px;
    height: 24px;
}
}

.verified-text {
color: #212529;
font-size: 12px;
margin: 0;
}

@media (min-width: 576px) {
.verified-text {
    font-size: 14px;
}
}

@media (min-width: 992px) {
.verified-text {
    font-size: 16px;
}
}

.color-custom-orange{
color:#ffbb38;
}

.bg-custom-orange-dark{
background-color: #ed7f30;
}

</style>
