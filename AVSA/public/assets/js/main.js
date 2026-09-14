document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.querySelector('.menu-toggle');
    const nav = document.querySelector('.main-nav');

    if (toggle && nav) {
        toggle.addEventListener('click', function () {
            nav.classList.toggle('open');
            const expanded = toggle.getAttribute('aria-expanded') === 'true';
            toggle.setAttribute('aria-expanded', String(!expanded));
        });
    }

    const counters = document.querySelectorAll('.stat-number');
    const animateCounter = (element) => {
        const target = Number(element.getAttribute('data-target') || 0);
        let current = 0;
        const step = Math.ceil(target / 40);
        const timer = setInterval(() => {
            current += step;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            element.textContent = current.toLocaleString() + '+';
        }, 30);
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                const el = entry.target;
                if (el.classList.contains('stat-number')) {
                    animateCounter(el);
                    observer.unobserve(el);
                }
            }
        });
    }, { threshold: 0.5 });

    counters.forEach((counter) => observer.observe(counter));

    const principleDetails = {
        compassion: {
            title: 'Compassion',
            description: 'We listen to people facing hardship and respond with kindness, practical care and respect. Our programs put the wellbeing of children, families and vulnerable communities first.'
        },
        integrity: {
            title: 'Integrity',
            description: 'We do what is right, keep our promises and use every resource responsibly. Our decisions, partnerships and services are guided by honesty and Biblical principles.'
        },
        dignity: {
            title: 'Dignity',
            description: 'We treat every person as valuable and created in the image of God. We provide support without shame, discrimination or humiliation, while protecting each person’s voice and choices.'
        },
        equality: {
            title: 'Equality',
            description: 'We work for fair access to health, education, protection and opportunity. We serve without discrimination and pay attention to people who are most often left behind.'
        },
        accountability: {
            title: 'Accountability',
            description: 'We are responsible to the communities we serve, our partners and our supporters. We listen to feedback, measure our work and learn when something needs to improve.'
        },
        community: {
            title: 'Community',
            description: 'We work with local leaders, caregivers and families, not above them. Strong, locally owned solutions help communities protect one another and build lasting change.'
        },
        transparency: {
            title: 'Transparency',
            description: 'We communicate clearly about our purpose, decisions, resources and results. Openness builds trust and helps the people we serve participate in our work.'
        },
        sustainability: {
            title: 'Sustainability',
            description: 'We seek solutions that continue beyond one project or donation. We strengthen local skills, systems and partnerships so progress can be maintained over time.'
        }
    };

    const principleButtons = document.querySelectorAll('[data-principle]');
    const principleDetail = document.querySelector('[data-principle-detail]');
    const principleTitle = document.querySelector('[data-principle-title]');
    const principleDescription = document.querySelector('[data-principle-description]');

    principleButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const principle = principleDetails[button.dataset.principle];
            if (!principle || !principleDetail) return;

            principleTitle.textContent = principle.title;
            principleDescription.textContent = principle.description;
            principleDetail.hidden = false;
            principleButtons.forEach((item) => item.classList.toggle('is-selected', item === button));
            principleDetail.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        });
    });
});
