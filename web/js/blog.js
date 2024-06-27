// const paginationNumbers = document.getElementById("pagination-numbers");
// const paginatedList = document.getElementById("paginated-list");
// const listItems = paginatedList.querySelectorAll(".card_");
// const nextButton = document.getElementById("next-button");
// const prevButton = document.getElementById("prev-button");
// var paginationLimit = '';
// if (window.innerWidth > 1100 || (window.innerWidth > 700 && window.innerWidth <= 926)) {
//     paginationLimit = 9;
// }
// if (window.innerWidth > 926 && window.innerWidth <= 1100) {
//     paginationLimit = 12;
// }
// if (window.innerWidth > 463 && window.innerWidth <= 700) {
//     paginationLimit = 6;
// }
// if (window.innerWidth <= 463) {
//     paginationLimit = 3;
// }
// let currentPage = 1;
// const pageCount = Math.ceil(listItems.length / paginationLimit);

// const disableButton = (button) => {
//     button.classList.add("disabled");
//     button.setAttribute("disabled", true);
// };
//
// const enableButton = (button) => {
//     button.classList.remove("disabled");
//     button.removeAttribute("disabled");
// };
//
// const handlePageButtonsStatus = () => {
//     if (currentPage === 1) {
//         disableButton(prevButton);
//     } else {
//         enableButton(prevButton);
//     }
//
//     if (currentPage === pageCount) {
//         disableButton(nextButton);
//     } else {
//         enableButton(nextButton);
//     }
// };

// const handleActivePageNumber = () => {
//     document.querySelectorAll(".pagination-number").forEach((button) => {
//         button.classList.remove("active");
//         const pageIndex = Number(button.getAttribute("page-index"));
//         if (pageIndex === currentPage) {
//             button.classList.add("active");
//         }
//     });
// };
//
// const appendPageNumber = (index) => {
//     const pageNumber = document.createElement("button");
//     pageNumber.className = "pagination-number";
//     pageNumber.innerHTML = index;
//     pageNumber.setAttribute("page-index", index);
//     pageNumber.setAttribute("aria-label", "Page " + index);
//
//     pageNumber.addEventListener("click", () => {
//         setCurrentPage(index);
//     });
//
//     paginationNumbers.appendChild(pageNumber);
// };

// const getPaginationNumbers = () => {
//     paginationNumbers.innerHTML = ""; // Clear existing numbers
//     for (let i = 1; i <= pageCount; i++) {
//         appendPageNumber(i);
//     }
// };

// const setCurrentPage = (pageNum) => {
//     currentPage = pageNum;
//
//     handleActivePageNumber();
//     handlePageButtonsStatus();
//
//     const startIndex = (pageNum - 1) * paginationLimit;
//     const endIndex = startIndex + paginationLimit;
//
//     listItems.forEach((item, index) => {
//         if (index >= startIndex && index < endIndex) {
//             item.style.display = "block";
//         } else {
//             item.style.display = "none";
//         }
//     });
// };

// window.addEventListener("load", () => {
//     getPaginationNumbers();
//     setCurrentPage(1);
//
//     prevButton.addEventListener("click", () => {
//         setCurrentPage(currentPage - 1);
//     });
//
//     nextButton.addEventListener("click", () => {
//         setCurrentPage(currentPage + 1);
//     });
// });
// Like js
document.querySelectorAll('.blog ion-icon').forEach(icon => {
    icon.addEventListener('click', function() {
        this.classList.toggle('active');
    });
});
let seeMoreBtnBlogs = document.querySelector('#blogsBtnMobile');
let blogs = [...document.querySelectorAll('.mobileBlogsFiled .card_')];
let currentItemBlogs = 2;
if (currentItemBlogs >= blogs.length) {
    seeMoreBtnBlogs.style.display = 'none';
}
seeMoreBtnBlogs.onclick = () => {
    let itemsToShow = 2;
    for (let i = currentItemBlogs; i < currentItemBlogs + itemsToShow; i++) {
        if (i < blogs.length) {
            blogs[i].style.display = 'block';
        }
    }
    currentItemBlogs += itemsToShow;
    if (currentItemBlogs >= blogs.length) {
        seeMoreBtnBlogs.style.display = 'none';
    }
}