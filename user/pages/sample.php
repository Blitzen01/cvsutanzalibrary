<!-- <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0" />
    <title>Starter Template - Materialize</title>
    <style>
        @import url("https://fonts.googleapis.com/css?family=Bungee+Hairline");

        .button {
            height: 56px;
            width: 56px;
            border-radius: 50%;
            border: 2px solid;
            border-color: white;
            cursor: pointer;
            outline: none;
            box-shadow: 0px 3px 5px -1px rgba(0, 0, 0, 0.2),
                0px 6px 10px 0px rgba(0, 0, 0, 0.14), 0px 1px 18px 0px rgba(0, 0, 0, 0.12);
            transition: all 300ms;
        }

        .button:hover {
            transform: scale(1.1);
            box-shadow: 0px 7px 8px -4px rgba(0, 0, 0, 0.2),
                0px 12px 17px 2px rgba(0, 0, 0, 0.14), 0px 5px 22px 4px rgba(0, 0, 0, 0.12);
        }

        #backButton {
            background: white url("https://firebasestorage.googleapis.com/v0/b/chris-rohr.appspot.com/o/codepen%2FGalactic_Empire_emblemIcon.png?alt=media&token=e00975c9-4f10-40fc-862a-3d8ecdc6ad02") no-repeat center;
            background-size: 48px 48px;

        }

        #backButton:hover {}

        #nextButton {
            background: white url("https://firebasestorage.googleapis.com/v0/b/chris-rohr.appspot.com/o/codepen%2FRebel_Alliance_logoIcon.png?alt=media&token=ffd9eccf-ed00-4556-bd53-d82832cca412") no-repeat center;
            background-size: 48px 48px;
        }

        #nextButton:hover {}

        .buttonContainer {
            position: absolute;
            display: flex;
            justify-content: space-between;
            top: calc(50% - 56px/2);
            margin: auto;
            padding: 0px 128px;
            width: calc(100% - 256px);
            z-index: 1;
        }

        @media only screen and (max-width: 1200px) {
            .buttonContainer {
                top: calc(90% - 56px);
                padding: 0px 32px;
                width: calc(100% - 64px);
            }
        }

        .container {
            margin: auto;
            height: 100%;
            width: 100%;
        }

        .img {
            margin: auto 16px;
            object-fit: contain;
            transition: transform 300ms;
            box-shadow: 0px 3px 5px -1px rgba(0, 0, 0, 0.2),
                0px 6px 10px 0px rgba(0, 0, 0, 0.14), 0px 1px 18px 0px rgba(0, 0, 0, 0.12);
        }

        @media only screen and (max-width: 600px) {
            .img {
                height: calc(50vh - 32px);
            }
        }

        .img:hover {
            transform: scale(1.1);
            box-shadow: 0px 7px 8px -4px rgba(0, 0, 0, 0.2),
                0px 12px 17px 2px rgba(0, 0, 0, 0.14), 0px 5px 22px 4px rgba(0, 0, 0, 0.12);
        }

        .item {
            height: 90%;
            width: 90%;

        }

        .slide {
            position: absolute;
            height: 80vh;
            width: 100%;
            margin: auto;
            display: flex;
            justify-content: center;
            align-items: center;
            transform-style: preserve-3d;
            transition: transform 500ms;
        }

        .slideContainer {
            height: calc(100vh - 32px);
            max-width: 1000px;
            margin: auto;
            display: flex;
            align-items: center;
            perspective: 5000px;
        }

        @media only screen and (max-width: 1200px) {
            .slideContainer {
                perspective: 3000px;
            }
        }

        @media only screen and (max-width: 600px) {
            .slideContainer {
                perspective: 1500px;
            }
        }

        .star {
            height: 15px;
            width: 15px;
        }

        #starField {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            height: 100vh;
            width: 100vw;
            z-index: 0;
        }

        .text {
            padding: 0 16px;
            transition: opacity 1s;
        }

        .title {
            font-size: 2rem;
            color: white;
            line-height: 2rem;
        }

        .year {
            font-size: 1.5rem;
            color: white;
            opacity: 0.8;
        }

        @media only screen and (max-width: 600px) {
            .title {
                font-size: 1.5em;
                color: white;
                line-height: 1.5rem;
            }

            .year {
                font-size: 1rem;
                color: white;
                opacity: 0.8;
            }
        }
    </style>
</head>

<body>

    <div id="container" class="container">
        <svg id="starField"></svg>
        <div class="buttonContainer">
            <button id="backButton" onclick="onChange(-1)" class="button" aria-label="back_button" />
            <button id="nextButton" onclick="onChange(+1)" class="button" aria-label="next_button" />
        </div>
        <div id="slideContainer" class="slideContainer" />
    </div>
</body>

<script>
    let index = 0;
    const url = "https://www.omdbapi.com/?s=star+wars&apikey=f94e2e41";
    const mykey =
        "http://www.omdbapi.com/?t=breaking+bad&plot=full&apikey=77fe56c8";
    let movies = [];
    let transform = [];
    let zIndex = [];

    fetchData = url => {
        fetch(url)
            .then(response => response.json())
            .then(json => {
                movies = json.Search;
                loadData();
            })
            .catch(err => {
                console.log(err.message, url);
            });
    };

    function loadData() {
        const container = document.getElementById("slideContainer");
        let i;
        for (i = 0; i < movies.length; i++) {
            transform.push(`translate3d(${i * 150}px, 0px, -${i * 1000}px)`);
            zIndex.push(`-${i}`);
            const movie = movies[i];
            const slide = document.createElement("div");

            const item = document.createElement("div");
            const text = document.createElement("div");
            const image = document.createElement("img");
            const title = document.createElement("h1");
            const year = document.createElement("h2");

            const titleNode = document.createTextNode(movie.Title);
            const yearNode = document.createTextNode(movie.Year);

            slide.setAttribute("class", "slide");
            item.setAttribute("class", "item");

            image.setAttribute("class", "img");
            image.setAttribute("src", movie.Poster);
            image.setAttribute("alt", movie.Title);

            text.setAttribute("class", "text");

            title.setAttribute("class", "title");
            year.setAttribute("class", "year");

            title.appendChild(titleNode);
            year.appendChild(yearNode);

            text.appendChild(title);
            text.appendChild(year);

            item.appendChild(image);
            item.appendChild(text);

            slide.appendChild(item);
            container.appendChild(slide);
        }
        if (i === movies.length) {
            showSlide(index);
        }
    }
    //RE-ASSIGN VALUE AT FIRST INDEX => LAST
    function onChange(toIndex) {
        if (toIndex === 1) {
            transform.unshift(transform[transform.length - 1]);
            transform.pop();
            zIndex.unshift(zIndex[zIndex.length - 1]);
            zIndex.pop();
        } else {
            transform.push(transform[0]);
            transform.shift();
            zIndex.push(zIndex[0]);
            zIndex.shift();
        }
        showSlide((index += toIndex));
    }

    function showSlide(toIndex) {
        let i;
        const slides = document.getElementsByClassName("slide");
        const text = document.getElementsByClassName("text");
        if (toIndex >= slides.length) {
            index = 0;
        }
        if (toIndex < 0) {
            index = slides.length - 1;
        }
        for (i = 0; i < slides.length; i++) {
            slides[i].style.transform = transform[i];
            slides[i].style.zIndex = zIndex[i];
            text[i].style.opacity = index === i ? 1 : 0;
        }
    }

    function mapStars() {
        const container = document.getElementById("starField");
        for (let i = 0; i < window.innerWidth; i++) {
            const star = document.createElementNS('http://www.w3.org/2000/svg', "circle");

            star.setAttribute("cx", Math.random() * window.innerWidth);
            star.setAttribute("cy", Math.random() * window.innerHeight);
            star.setAttribute("fill", "#eee");
            star.setAttribute("opacity", Math.random());
            star.setAttribute("r", Math.random() + 1);
            container.appendChild(star);
        }
    }
    mapStars();
    fetchData(url);
</script> -->