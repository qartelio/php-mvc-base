<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: #f1f5f9;
            max-width: 100%;
            overflow-x: hidden;
        }
        .container {
            max-width: 480px;
            margin: 0 auto;
            background: #ffffff;
            min-height: 100vh;
            position: relative;
            padding: 16px;
        }
        .header {
            display: flex;
            align-items: center;
            margin-bottom: 24px;
            position: relative;
        }
        .back-button {
            background: none;
            border: none;
            padding: 8px;
            cursor: pointer;
            color: #596D85;
            position: absolute;
            left: 0;
        }
        .title {
            font-size: 29px;
            font-weight: 700;
            width: 100%;
            text-align: center;
            color: #2D3748;
        }
        .subtitle {
            text-align: center;
            font-size: 24px;
            margin-bottom: 24px;
            font-weight: 700;
            color: #2D3748;
        }
        .button-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .personality-button {
            width: 100%;
            padding: 14px 16px;
            border: none;
            border-radius: 12px;
            background: white;
            color: #1f2937;
            font-family: 'Source Sans 3', sans-serif;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            border: 1px solid #f1f5f9;
        }
        .personality-button:hover {
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }
        .personality-button:active {
            transform: scale(0.98);
            background-color: #f8fafc;
        }
        .button-icon {
            background: #dbeafe;
            padding: 10px;
            border-radius: 12px;
            margin-right: 16px;
            color: #2563eb;
        }
        .button-arrow {
            margin-left: auto;
            color: #94a3b8;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            backdrop-filter: blur(5px);
        }

        .modal-content {
            position: relative;
            background-color: white;
            margin: 20px auto;
            padding: 32px;
            width: 90%;
            max-width: 600px;
            max-height: 85vh;
            overflow-y: auto;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .close-button {
            position: absolute;
            right: 24px;
            top: 24px;
            font-size: 28px;
            cursor: pointer;
            color: #4A5568;
            background: none;
            border: none;
            padding: 8px;
            border-radius: 50%;
            transition: all 0.2s ease;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .close-button:hover {
            background-color: #EDF2F7;
            color: #2D3748;
        }

        .modal-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 24px;
            color: #2D3748;
            padding-bottom: 16px;
            border-bottom: 2px solid #E2E8F0;
        }

        .modal-text {
            line-height: 1.8;
            margin-bottom: 24px;
            color: #4A5568;
            font-size: 16px;
        }

        .modal-section {
            margin: 24px 0;
            padding: 24px;
            background-color: #F8FAFC;
            border-radius: 12px;
            border: 1px solid #E2E8F0;
        }

        .section-title {
            font-weight: 700;
            font-size: 20px;
            margin-bottom: 16px;
            color: #2D3748;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-title::before {
            content: "";
            display: block;
            width: 4px;
            height: 24px;
            background: linear-gradient(135deg, #667EEA 0%, #764BA2 100%);
            border-radius: 2px;
        }

        .characteristic-list {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .characteristic-list li {
            margin-bottom: 12px;
            padding-left: 24px;
            position: relative;
            color: #4A5568;
        }

        .characteristic-list li::before {
            content: "•";
            color: #667EEA;
            font-weight: bold;
            position: absolute;
            left: 0;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-item {
            background: white;
            padding: 16px;
            border-radius: 8px;
            border: 1px solid #E2E8F0;
        }

        .stat-label {
            font-size: 14px;
            color: #718096;
            margin-bottom: 4px;
        }

        .stat-value {
            font-size: 18px;
            font-weight: 600;
            color: #2D3748;
        }

        @media (max-width: 480px) {
            .modal-content {
                padding: 24px;
                margin: 16px;
                width: auto;
            }
        }
    </style>
</head>
<body>
    <div class="container mx-auto px-4 py-8">
        <div class="header">
            <a href="index.php" class="back-button">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h1 class="title">Университеты</h1>
        </div>

        <h2 class="subtitle" style="font-size: 120%;">Uzdik болмен Uzdik университетті таңда</h2>

        <div class="button-list">
            <button class="personality-button" data-type="Толық қаржыландыру">
                <div class="button-icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                Толық қаржыландыру
                <svg class="w-5 h-5 button-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>

            <button class="personality-button" data-type="Жартылай қаржыландыру">
                <div class="button-icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                </div>
                Жартылай қаржыландыру
                <svg class="w-5 h-5 button-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>

            <button class="personality-button" data-type="Жартылай көмек, 40 000$">
                <div class="button-icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                Жартылай көмек, 40 000$
                <svg class="w-5 h-5 button-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>

            <button class="personality-button" data-type="Жартылай көмек, 20 000$">
                <div class="button-icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                Жартылай көмек, 20 000$
                <svg class="w-5 h-5 button-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Modal Template -->
    <div id="personalityModal" class="modal">
        <div class="modal-content">
            <button class="close-button">&times;</button>
            <h2 class="modal-title"></h2>
            <div class="modal-body"></div>
        </div>
    </div>

    <script>
    const personalityData = {
        "Толық қаржыландыру": {
          title: "Толық қаржыландыратын университеттер",
          description: "Толық қаржыландыруды ұсынатын университеттердің тізімі",
            stats: {},
            characteristics: [],
            careers: [
                "Sarah Lawrence College",
                "Georgia Institute of Technology",
                "Amherst College",
                "Skidmore College",
                "Gettysburg College",
                "Bard College",
                "Smith College",
                "Gonzaga University",
                "Barnard College",
                "Stanford University",
                "Goucher College",
                "Bates College",
                "Swarthmore College",
                "Hampshire College",
                "Bennington College",
                "The College of Wooster",
                "Harvey Mudd College",
                "Berea College",
                "Tufts University",
                "Haverford College",
                "Bowdoin College",
                "Union College",
                "Hendrix College",
                "Brandeis University",
                "University of Pennsylvania",
                "Hobart and William Smith Colleges",
                "Brown University",
                "University of Rochester",
                "Howard University",
                "Bryn Mawr College",
                "Vanderbilt University",
                "Illinois Institute of Technology",
                "Bucknell University",
                "Vassar College",
                "Indiana University-Purdue University Indianapolis",
                "Carleton College",
                "Wellesley College",
                "Ithaca College",
                "Claremont McKenna College",
                "Wesleyan University",
                "Lesley University",
                "Colby College",
                "Whitman College",
                "Loyola Marymount University",
                "Colgate University",
                "Williams College",
                "Loyola University Chicago",
                "Colorado College",
                "Yale University",
                "Loyola University Maryland"
            ],
            values: [],
            perception: []
        },
        "Жартылай қаржыландыру": {
          title: "Жартылай ққаржылай көмектесетін университеттер",
          description: "Жартылай қаржыландыруды ұсынатын университеттердің тізімі",
            stats: {},
            characteristics: [],
            careers: [
                "Dartmouth University",
                "Ashesi University",
                "Michigan State University",
                "Davidson College",
                "Babson College",
                "Mills College",
                "Deep Springs College",
                "Berkeley College of Music",
                "Morehouse College",
                "Denison University",
                "California Institute of Technology",
                "Occidental College",
                "Dickinson College",
                "Chapman University",
                "Ohio Wesleyan University",
                "Duke University",
                "Clark University",
                "Pepperdine University",
                "Georgetown University",
                "College of William and Mary",
                "Providence College",
                "Grinnell College",
                "Concours de Sciences Politiques",
                "Quest University Canada",
                "Hamilton College - NY",
                "Connecticut College",
                "Rensselaer Polytechnic Institute",
                "Harvard University",
                "Cornell College",
                "Savannah College of Art and Design - Atlanta",
                "Jacobs University Bremen",
                "DePaul University",
                "Scripps College",
                "Johns Hopkins University",
                "DePauw University",
                "Sewanee: The University of the South",
                "Kalamazoo College",
                "Dillard University",
                "St. John's College",
                "Kenyon College",
                "Drew University",
                "St. Olaf College",
                "Lafayette College",
                "Drexel University",
                "Sweet Briar College",
                "Lehigh University",
                "Earlham College",
                "United States International University",
                "Macalester College",
                "Eckerd College",
                "University of Cincinnati",
                "MIT",
                "Elmira College",
                "Villanova University",
                "Middlebury College",
                "Emory University",
                "Washington and Jefferson College",
                "Mount Holyoke College",
                "Endicott College",
                "Washington and Lee University",
                "New York University - Abu Dhabi",
                "Eugene Lang College The New School for Liberal Arts",
                "Washington University in St. Louis",
                "Northwestern University",
                "Fairfield University",
                "West Virginia University",
                "Oberlin College",
                "Fordham College at Lincoln Center",
                "Westminster College",
                "Pomona College",
                "Fordham University",
                "Wheaton College MA",
                "Princeton University",
                "Franklin and Marshall College",
                "Worcester Polytechnic Institute",
                "Reed College",
                "Franklin College Switzerland",
                "Rice University",
                "Franklin W. Olin College of Engineering"
            ],
            values: [],
            perception: []
        },
        "Жартылай көмек, 40 000$": {
          title: "40 000$ дейінгі қаржылық көмек көрсететін университеттер",
          description: "40 000$ дейінгі қаржылық көмек ұсынатын университеттердің тізімі",
            stats: {},
            characteristics: [],
            careers: [
                "National University of Singapore",
                "Anderson University",
                "Georgetown College",
                "New College of Florida",
                "Andrews University",
                "Georgia College and State University",
                "New York Institute of Business Technology",
                "Anna Maria College",
                "Gordon College",
                "New York Institute of Technology - Manhattan",
                "Arcadia University",
                "Goshen College",
                "North Central College",
                "Armstrong Atlantic State",
                "Grambling State University",
                "Northeastern University",
                "Art Academy of Cincinnati",
                "Gustavus Adolphus College",
                "Northwestern College",
                "Augsburg College",
                "Hampden-Sydney College",
                "Oglethorpe University",
                "Austin College",
                "Hanover College",
                "Ohio University",
                "Baldwin-Wallace College",
                "Hartwick College",
                "Otterbein University",
                "Ball State University",
                "Hawaii Pacific University",
                "Pacific Lutheran University",
                "Beloit College",
                "Hiram College",
                "Pittsburg State University",
                "Bentley University",
                "Hofstra University",
                "Pitzer College",
                "Bradley University",
                "Hood College",
                "Point Park University",
                "Bryant University",
                "Hope College",
                "Pratt Institute",
                "Butler University",
                "Illinois State University",
                "Purdue University",
                "California Lutheran University",
                "Illinois Wesleyan University",
                "Quinnipiac University",
                "California University of Pennsylvania",
                "Indiana State University",
                "Randolph College",
                "Calvin College",
                "Indiana Tech",
                "Regis University",
                "Carleton University",
                "Iowa State University",
                "Rhode Island School of Design",
                "Centre College",
                "John Carroll University",
                "Rhodes College",
                "Champlain College",
                "Juniata College",
                "Rhodes University",
                "Clark Atlanta University",
                "Knox College",
                "Ripon College",
                "Clarkson University",
                "La Salle University",
                "Roanoke College",
                "Coe College",
                "Lake Forest College",
                "Rochester College",
                "College of Eastern Utah",
                "Lawrence Technological University",
                "Rochester Institute of Technology",
                "College of Saint Benedict",
                "Lawrence University",
                "Rockford College",
                "College of St. Scholastica",
                "Luther College",
                "Rollins College",
                "College of the Holy Cross",
                "Lynn University",
                "Sacred Heart University",
                "Colorado School of Mines",
                "Manhattan College",
                "Saint Augustine's College - NC",
                "Colorado Technical University",
                "Manhattanville College",
                "Saint Joseph's University",
                "Columbia College",
                "Marietta College",
                "Saint Luke's College",
                "Concordia College - Bronxville",
                "Marlboro College",
                "Saint Mary's College of California",
                "Concordia University - Montreal",
                "Marymount Manhattan College",
                "Saint Mary's University",
                "Creighton University",
                "McGill University",
                "Saint Peter's College",
                "Curry College",
                "McMaster University",
                "Santa Clara University",
                "Curtin International College",
                "Medaille College",
                "Seattle University",
                "Dalhousie University",
                "Meredith College",
                "Seoul National University",
                "Davenport University",
                "Merrimack College",
                "Seton Hill University",
                "De Montfort University",
                "Messiah College",
                "Siena College",
                "Drake University",
                "Millikin University",
                "Simmons College",
                "East Carolina University",
                "Millsaps College",
                "Southeastern Business College (New Boston)"
            ],
            values: [],
            perception: []
        },
        "Жартылай көмек, 20 000$": {
          title: "20 000$ дейінгі қаржылық көмек көрсететін университеттер",
            description: "20 000$ дейінгі қаржылық көмек ұсынатын университеттердің тізімі",
            stats: {},
            characteristics: [],
            careers: [
                "University of Denver",
                "Westwood College",
                "Southern Methodist University",
                "University of Georgia",
                "Willamette University",
                "Southern New Hampshire University",
                "University of Hartford",
                "William Jewell College",
                "Southern Oregon University",
                "University of Hong Kong",
                "Wilson College",
                "Spelman College",
                "University of Johannesburg",
                "Wittenberg University",
                "Springfield College",
                "University of Maine at Farmington",
                "St. Catherine University - St. Paul",
                "University of Mary Washington",
                "Xavier University",
                "St. John's University - Manhattan Campus",
                "University of Maryland",
                "Xavier University of Louisiana",
                "St. John's University - Queens",
                "University of Massachusetts",
                "Yonsei University",
                "St. Lawrence University",
                "University of Miami",
                "York University",
                "St. Thomas University",
                "University of Michigan",
                "Stetson University",
                "University of Minnesota",
                "Stony Brook University",
                "University of New England",
                "Suffolk University",
                "University of New Hampshire",
                "Susquehanna University",
                "University of Notre Dame",
                "Syracuse University",
                "University of Oklahoma",
                "Temple University",
                "University of Oregon",
                "Texas A&M University",
                "University of Ottawa",
                "Texas Christian University",
                "University of Pretoria",
                "The American University of Paris",
                "University of Redlands",
                "The Chinese University of Hong Kong",
                "University of Richmond",
                "The College of Idaho",
                "University of San Diego",
                "The George Washington University",
                "University of Saskatchewan",
                "The Hong Kong University of Science & Technology",
                "University of Southampton",
                "The Juilliard School",
                "University of Southern California",
                "The University of Arizona",
                "University of the Pacific",
                "The University of Iowa",
                "University of the Witwatersrand",
                "The University of North Carolina at Chapel Hill",
                "The University of Tampa",
                "University of Virginia",
                "Thompson Rivers University",
                "University of Washington",
                "Trent University",
                "University of Waterloo",
                "Trinity College",
                "Ursinus College",
                "Trinity University",
                "Utica College",
                "Truman State University",
                "Victoria University",
                "Tulane University",
                "Virginia Polytechnic Institute and State University",
                "Université de Montréal",
                "Vlerick Leuven Gent Management School",
                "Université Catholique de Louvain",
                "Wabash College",
                "Wagner College",
                "University of British Columbia",
                "Wake Forest University",
                "University of California at Berkeley",
                "University of California at Davis",
                "University of California at Los Angeles",
                "Washington College",
                "University of California at San Diego",
                "Washington State University",
                "Vancouver",
                "University of Cape Town",
                "Webster University",
                "University of Colorado at Boulder",
                "Wentworth Institute"
            ],
            values: [],
            perception: []
        }
    };

        document.querySelectorAll('.personality-button').forEach(button => {
            button.addEventListener('click', () => {
                const type = button.dataset.type;
                const data = personalityData[type];

                const modal = document.getElementById('personalityModal');
                const modalTitle = modal.querySelector('.modal-title');
                const modalBody = modal.querySelector('.modal-body');

                modalTitle.textContent = data.title;

                // Create the modal content
                let modalContent = `
                    <p class="modal-text">${data.description}</p>

                    <div class="stats-grid">
                        ${Object.entries(data.stats).map(([label, value]) => `
                            <div class="stat-item">
                                <div class="stat-label">${label}</div>
                                <div class="stat-value">${value}</div>
                            </div>
                        `).join('')}
                    </div>


                    <div class="modal-section">
                        <h3 class="section-title">Тізім</h3>
                        <ul class="characteristic-list">
                            ${data.careers.map(career => `<li>${career}</li>`).join('')}
                        </ul>
                    </div>
                `;

                modalBody.innerHTML = modalContent;
                modal.style.display = 'block';
                document.body.style.overflow = 'hidden';
            });
        });

        // Close modal when clicking the close button or outside the modal
        document.querySelector('.close-button').addEventListener('click', () => {
            document.getElementById('personalityModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        });

        window.addEventListener('click', (event) => {
            const modal = document.getElementById('personalityModal');
            if (event.target === modal) {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        });
    </script>
</body>
</html>
