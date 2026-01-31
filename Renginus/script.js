function previewImages(event) {
    const previewContainer = document.getElementById('image-preview-container');
    const files = event.target.files;

    Array.from(files).forEach(file => {
        const reader = new FileReader();
        reader.onload = (e) => {
            const img = document.createElement('img');
            img.src = e.target.result;
            previewContainer.appendChild(img);
        };
        reader.readAsDataURL(file);
    });
}

function togglePrice() {
    const paidSelect = document.getElementById('paid').checked;
    const priceContainer = document.getElementById('price-container');
    
    priceContainer.style.display = (paidSelect != true) ? 'block' : 'none';
}

function previewProfilePicture(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('picture_preview');
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}



const events = [
    { 
        eventName: "Vasaros saskrydis", 
        eventDate: "2025-06-14", 
        eventType: "Šventė", 
        eventImage: "placeholder.jpg",  
        eventUrl: "https://placehold.co/"  
    },
    { 
        eventName: "Pavasario konferencija", 
        eventDate: "2025-04-01", 
        eventType: "Konferencija", 
        eventImage: "placeholder.jpg", 
        eventUrl: "https://placehold.co/"  
    },
    { 
        eventName: "Personalo mokymai", 
        eventDate: "2025-05-10", 
        eventType: "Mokymai", 
        eventImage: "placeholder.jpg", 
        eventUrl: "https://placehold.co/"  
    },
    { 
        eventName: "Pavasario šventė", 
        eventDate: "2025-03-10", 
        eventType: "Šventė", 
        eventImage: "placeholder.jpg", 
        eventUrl: "https://placehold.co/"  
    }
];

function loadEvents(eventType) {
    const today = new Date();
    const eventsList = document.getElementById('events_list');
    eventsList.innerHTML = '';
    let filteredEvents = [];


    if (eventType === 'upcoming') {
        filteredEvents = events.filter(event => new Date(event.eventDate) >= today);
    } else if (eventType === 'past') {
        filteredEvents = events.filter(event => new Date(event.eventDate) < today);
    }

        filteredEvents.forEach(event => {
            const li = document.createElement('li');
            li.classList.add('event-item'); // 
            const eventLink = document.createElement('a');
            eventLink.href = event.eventUrl; 
            eventLink.target = "_blank"; 
            eventLink.innerHTML = `
                <div class="event-info">
                    <img src="${event.eventImage}" alt="${event.eventName}" class="event-image">
                    <div class="event-details">
                        <h3>${event.eventName}</h3>
                        <p>${event.eventType}</p>
                        <p><strong>${new Date(event.eventDate).toLocaleDateString()}</strong></p>
                    </div>
                </div>
            `;
            li.appendChild(eventLink);
            eventsList.appendChild(li);
        });
    }

function Upload(event){
    
    let file = document.getElementById("formFile");
    event.preventDefault();
    file.click();
}

