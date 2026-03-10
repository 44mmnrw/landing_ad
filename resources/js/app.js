import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
	const modal = document.getElementById('calcModal');
	if (!modal) {
		return;
	}

	const openButtons = document.querySelectorAll('.js-open-calc-modal');
	const closeButtons = modal.querySelectorAll('[data-calc-modal-close]');
	const successAlert = modal.querySelector('.form-alert--success');
	const phoneInput = modal.querySelector('input[name="phone"]');
	const closeAnimationDuration = 6000;
	const successCloseDelay = 700;
	let closeAnimationTimer = null;

	const formatPhone = (rawValue) => {
		const digits = String(rawValue).replace(/\D/g, '');
		let normalized = digits;

		if (normalized.startsWith('8')) {
			normalized = `7${normalized.slice(1)}`;
		}

		if (!normalized.startsWith('7')) {
			normalized = `7${normalized}`;
		}

		normalized = normalized.slice(0, 11);
		const body = normalized.slice(1);

		let result = '+7';

		if (body.length > 0) {
			result += ` (${body.slice(0, 3)}`;
		}

		if (body.length >= 3) {
			result += ')';
		}

		if (body.length > 3) {
			result += ` ${body.slice(3, 6)}`;
		}

		if (body.length > 6) {
			result += `-${body.slice(6, 8)}`;
		}

		if (body.length > 8) {
			result += `-${body.slice(8, 10)}`;
		}

		return result;
	};

	const openModal = () => {
		if (closeAnimationTimer) {
			window.clearTimeout(closeAnimationTimer);
			closeAnimationTimer = null;
		}

		modal.classList.remove('is-closing');
		modal.classList.add('is-open');
		modal.setAttribute('aria-hidden', 'false');
		document.body.classList.add('modal-open');
	};

	const closeModal = (withAnimation = false) => {
		if (!modal.classList.contains('is-open')) {
			return;
		}

		if (!withAnimation) {
			modal.classList.remove('is-open', 'is-closing');
			modal.setAttribute('aria-hidden', 'true');
			document.body.classList.remove('modal-open');
			return;
		}

		if (closeAnimationTimer) {
			window.clearTimeout(closeAnimationTimer);
		}

		modal.classList.add('is-closing');
		modal.setAttribute('aria-hidden', 'true');
		document.body.classList.remove('modal-open');

		closeAnimationTimer = window.setTimeout(() => {
			modal.classList.remove('is-open', 'is-closing');
			closeAnimationTimer = null;
		}, closeAnimationDuration);
	};

	openButtons.forEach((button) => {
		button.addEventListener('click', (event) => {
			event.preventDefault();
			openModal();
		});
	});

	closeButtons.forEach((button) => {
		button.addEventListener('click', closeModal);
	});

	document.addEventListener('keydown', (event) => {
		if (event.key === 'Escape' && modal.classList.contains('is-open')) {
			closeModal();
		}
	});

	if (phoneInput) {
		phoneInput.addEventListener('focus', () => {
			if (!phoneInput.value.trim()) {
				phoneInput.value = '+7 (';
			}
		});

		phoneInput.addEventListener('input', () => {
			phoneInput.value = formatPhone(phoneInput.value);
		});

		phoneInput.addEventListener('blur', () => {
			const digits = phoneInput.value.replace(/\D/g, '');

			if (digits.length <= 1) {
				phoneInput.value = '';
			}
		});

		phoneInput.value = formatPhone(phoneInput.value);
	}

	if (modal.dataset.autoOpen === '1' || successAlert) {
		openModal();

		if (successAlert) {
			window.setTimeout(() => {
				closeModal(true);
			}, successCloseDelay);
		}
	}

	const carouselContainers = document.querySelectorAll('.js-section-carousel[data-carousel-enabled="1"]');

	carouselContainers.forEach((container) => {
		if (!container.parentElement?.classList.contains('section-carousel-viewport')) {
			const viewport = document.createElement('div');
			viewport.className = 'section-carousel-viewport';
			container.parentElement?.insertBefore(viewport, container);
			viewport.appendChild(container);
		}

		const viewport = container.parentElement;

		if (!(viewport instanceof HTMLElement)) {
			return;
		}

		const slides = Array.from(container.children).filter((node) => node instanceof HTMLElement);

		if (slides.length < 2) {
			return;
		}

		const parsedSpeed = Number.parseInt(container.dataset.carouselSpeed ?? '3500', 10);
		const speed = Number.isFinite(parsedSpeed) ? Math.max(500, parsedSpeed) : 3500;
		let intervalId = null;
		let isAnimating = false;

		container.classList.add('is-carousel-enabled');

		const seedSlides = slides.map((slide) => slide.cloneNode(true));
		let cloneIndex = 0;

		const ensureOverflowBuffer = () => {
			let guard = 0;

			while (container.scrollWidth <= viewport.clientWidth + 1 && guard < seedSlides.length * 4) {
				const sourceNode = seedSlides[cloneIndex % seedSlides.length];

				if (!(sourceNode instanceof HTMLElement)) {
					break;
				}

				const clone = sourceNode.cloneNode(true);

				if (clone instanceof HTMLElement) {
					clone.classList.add('is-carousel-clone');
					clone.setAttribute('aria-hidden', 'true');
					container.appendChild(clone);
				}

				cloneIndex += 1;
				guard += 1;
			}
		};

		ensureOverflowBuffer();
		window.addEventListener('resize', ensureOverflowBuffer);

		const getGap = () => {
			const styles = window.getComputedStyle(container);
			const rawGap = styles.columnGap || styles.gap || '24px';
			const parsedGap = Number.parseFloat(rawGap);

			return Number.isFinite(parsedGap) ? parsedGap : 24;
		};

		const moveNext = () => {
			if (isAnimating) {
				return;
			}

			const first = container.firstElementChild;

			if (!(first instanceof HTMLElement)) {
				return;
			}

			const step = first.getBoundingClientRect().width + getGap();

			if (!Number.isFinite(step) || step <= 0) {
				return;
			}

			isAnimating = true;
			container.style.setProperty('--carousel-shift', `${step}px`);
			container.classList.add('is-carousel-moving');

			let fallbackTimer = null;

			const finish = () => {
				if (!isAnimating) {
					return;
				}

				isAnimating = false;
				container.classList.remove('is-carousel-moving');
				container.style.removeProperty('--carousel-shift');
				container.appendChild(first);

				if (fallbackTimer) {
					window.clearTimeout(fallbackTimer);
					fallbackTimer = null;
				}
			};

			const handleTransitionEnd = (event) => {
				if (event.target !== container || event.propertyName !== 'transform') {
					return;
				}

				container.removeEventListener('transitionend', handleTransitionEnd);
				finish();
			};

			container.addEventListener('transitionend', handleTransitionEnd);
			fallbackTimer = window.setTimeout(() => {
				container.removeEventListener('transitionend', handleTransitionEnd);
				finish();
			}, 800);
		};

		const stop = () => {
			if (intervalId !== null) {
				window.clearInterval(intervalId);
				intervalId = null;
			}
		};

		const start = () => {
			stop();
			intervalId = window.setInterval(() => {
				moveNext();
			}, speed);
		};

		container.addEventListener('mouseenter', stop);
		container.addEventListener('mouseleave', start);
		container.addEventListener('focusin', stop);
		container.addEventListener('focusout', start);

		start();
	});
});
