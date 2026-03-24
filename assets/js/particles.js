(function() {
const canvas = document.getElementById('particles-canvas');
if (!canvas) return;
const ctx = canvas.getContext('2d');
function sizeCanvas() { canvas.width = window.innerWidth; canvas.height = window.innerHeight; }
sizeCanvas();
const style = getComputedStyle(document.body);
const colorA = style.getPropertyValue('--primary-green').trim() || '#2E4A33';

function rand(min, max){return Math.random()*(max-min)+min;}

class Cube {
  constructor() {
    this.reset(true);
  }

  reset(initial = false) {
    this.size = rand(60, 150); // Larger, impactful sizes
    this.x = rand(0, canvas.width - this.size);
    // If initial, scatter vertically; otherwise start below bottom
    this.y = initial ? rand(0, canvas.height) : canvas.height + this.size;
    this.speed = rand(0.5, 1.5); // Slow, steady rising
    this.opacity = rand(0.05, 0.15); // Very subtle
    this.rotation = rand(0, 360);
    this.rotationSpeed = rand(-0.2, 0.2); // Gentle rotation
  }

  draw() {
    ctx.save();
    ctx.translate(this.x + this.size/2, this.y + this.size/2);
    ctx.rotate(this.rotation * Math.PI / 180);
    
    // Draw just the stroke or a very faint fill for a "wireframe" or "glass" look
    ctx.strokeStyle = colorA;
    ctx.lineWidth = 2;
    ctx.globalAlpha = this.opacity;
    
    // Draw square
    ctx.strokeRect(-this.size/2, -this.size/2, this.size, this.size);
    
    // Optional: Fill slightly
    ctx.fillStyle = colorA;
    ctx.globalAlpha = this.opacity * 0.3;
    ctx.fillRect(-this.size/2, -this.size/2, this.size, this.size);
    
    ctx.restore();
  }

  update() {
    this.y -= this.speed;
    this.rotation += this.rotationSpeed;

    // Reset if it goes off top
    if (this.y < -this.size * 1.5) {
      this.reset(false);
    }
    this.draw();
  }
}

let cubes = [];
function init() {
  cubes = [];
  // Keep count low for a professional, uncluttered look
  // e.g. 10-15 cubes on a typical desktop
  const area = canvas.width * canvas.height;
  let count = Math.max(8, Math.min(20, Math.floor(area / 100000))); 
  
  for (let i = 0; i < count; i++) {
    cubes.push(new Cube());
  }
}

function animate() {
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  for (let i = 0; i < cubes.length; i++) {
    cubes[i].update();
  }
  requestAnimationFrame(animate);
}

window.addEventListener('resize', () => { sizeCanvas(); init(); });
init();
animate();
})();
