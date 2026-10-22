{{--
    Compartilhamento do artigo.

    Copiar link: copia a URL e mostra um aviso.
    Instagram Stories: o Instagram não aceita link de compartilhamento pela web,
    então a página desenha um card vertical (1080×1920) do artigo no navegador e
    abre a folha de compartilhamento do celular com a imagem, onde o Instagram
    aparece como destino. O link vai junto para a área de transferência, para
    ser colado no adesivo de link do story. Sem suporte a compartilhar arquivos
    (desktop), a imagem é baixada.
--}}
<script>
    (function () {
        var toast = document.querySelector('[data-share-toast]');
        var toastTimer;

        function notify(message) {
            toast.textContent = message;
            toast.classList.add('opacity-100');
            clearTimeout(toastTimer);
            toastTimer = setTimeout(function () {
                toast.classList.remove('opacity-100');
            }, 4200);
        }

        function copy(text) {
            return navigator.clipboard ? navigator.clipboard.writeText(text) : Promise.reject();
        }

        document.querySelectorAll('[data-copy-link]').forEach(function (button) {
            button.addEventListener('click', function () {
                copy(button.dataset.copyLink).then(function () { notify('Link copiado'); });
            });
        });

        var storyButton = document.querySelector('[data-story]');

        if (!storyButton) {
            return;
        }

        var story = JSON.parse(storyButton.dataset.story);
        var palettes = {
            'clay': { bg: '#9f4f30', fg: '#f9f2e9', accent: '#e1a948' },
            'ink': { bg: '#33211b', fg: '#f9f2e9', accent: '#e1a948' },
            'sand': { bg: '#ecdbc8', fg: '#763927', accent: '#9f4f30' },
            'clay-deep': { bg: '#763927', fg: '#f9f2e9', accent: '#e1a948' },
            'ochre': { bg: '#e1a948', fg: '#33211b', accent: '#763927' }
        };
        var storyFile = null;

        function wrap(ctx, text, maxWidth) {
            var words = text.split(' ');
            var lines = [];
            var line = '';

            words.forEach(function (word) {
                var candidate = line ? line + ' ' + word : word;

                if (ctx.measureText(candidate).width > maxWidth && line) {
                    lines.push(line);
                    line = word;
                } else {
                    line = candidate;
                }
            });

            if (line) {
                lines.push(line);
            }

            return lines;
        }

        function spaced(ctx, value) {
            if ('letterSpacing' in ctx) {
                ctx.letterSpacing = value;
            }
        }

        function draw() {
            var W = 1080;
            var H = 1920;
            var pad = 96;
            var palette = palettes[story.tone] || palettes.clay;
            var canvas = document.createElement('canvas');
            var ctx = canvas.getContext('2d');

            canvas.width = W;
            canvas.height = H;

            ctx.fillStyle = palette.bg;
            ctx.fillRect(0, 0, W, H);

            // Número do artigo, grande e discreto, ao fundo.
            ctx.save();
            ctx.globalAlpha = 0.14;
            ctx.fillStyle = palette.fg;
            ctx.font = 'italic 400 760px "Bodoni Moda", Georgia, serif';
            ctx.textBaseline = 'alphabetic';
            ctx.fillText(story.number, pad - 30, H - 120);
            ctx.restore();

            // Fio do logo.
            ctx.save();
            ctx.translate(W - 620, 250);
            ctx.scale(2, 2);
            ctx.strokeStyle = palette.accent;
            ctx.lineWidth = 1.6;
            ctx.lineCap = 'round';
            ctx.stroke(new Path2D('M4 44 C 60 46, 92 14, 132 12 C 166 10, 172 44, 148 46 C 126 48, 128 18, 168 14 C 218 9, 262 40, 306 22'));
            ctx.beginPath();
            ctx.arc(308, 21, 4.2, 0, Math.PI * 2);
            ctx.fillStyle = palette.accent;
            ctx.fill();
            ctx.restore();

            ctx.fillStyle = palette.fg;
            ctx.textBaseline = 'alphabetic';

            ctx.font = '500 30px Figtree, sans-serif';
            spaced(ctx, '6px');
            ctx.fillText('DRA. EMILY BEATRIZ', pad, 250);

            ctx.globalAlpha = 0.8;
            ctx.font = '500 32px Figtree, sans-serif';
            spaced(ctx, '5px');
            ctx.fillText(story.eyebrow.toUpperCase(), pad, 470);
            ctx.globalAlpha = 1;
            spaced(ctx, '0px');

            var titleSize = 100;
            var titleLines;

            do {
                ctx.font = '400 ' + titleSize + 'px "Bodoni Moda", Georgia, serif';
                titleLines = wrap(ctx, story.title, W - pad * 2);
                titleSize -= 6;
            } while (titleLines.length > 5 && titleSize > 64);

            var lineHeight = (titleSize + 6) * 1.1;
            var y = 470 + 60 + lineHeight;

            titleLines.forEach(function (line) {
                ctx.fillText(line, pad, y);
                y += lineHeight;
            });

            ctx.globalAlpha = 0.85;
            ctx.font = '400 42px "Source Serif 4", Georgia, serif';
            y += 30;
            wrap(ctx, story.excerpt, W - pad * 2).slice(0, 5).forEach(function (line) {
                ctx.fillText(line, pad, y);
                y += 61;
            });
            ctx.globalAlpha = 1;

            ctx.fillStyle = palette.accent;
            ctx.fillRect(pad, H - 380, 72, 3);

            ctx.fillStyle = palette.fg;
            ctx.font = '500 40px Figtree, sans-serif';
            ctx.fillText('Leia o artigo completo', pad, H - 310);
            ctx.globalAlpha = 0.75;
            ctx.font = '400 32px Figtree, sans-serif';
            ctx.fillText(story.domain, pad, H - 260);
            ctx.globalAlpha = 1;

            return new Promise(function (resolve) {
                canvas.toBlob(function (blob) {
                    resolve(new File([blob], 'story-' + story.slug + '.png', { type: 'image/png' }));
                }, 'image/png');
            });
        }

        function build() {
            var fonts = [
                '400 100px "Bodoni Moda"',
                'italic 400 100px "Bodoni Moda"',
                '400 42px "Source Serif 4"',
                '500 32px Figtree'
            ];

            return Promise.all(fonts.map(function (font) { return document.fonts.load(font); }))
                .catch(function () {})
                .then(draw)
                .then(function (file) { storyFile = file; return file; });
        }

        function download(file) {
            var link = document.createElement('a');
            link.href = URL.createObjectURL(file);
            link.download = file.name;
            link.click();
            setTimeout(function () { URL.revokeObjectURL(link.href); }, 1000);
        }

        // A imagem fica pronta antes do clique: o navegador só abre a folha de
        // compartilhamento logo depois do gesto do usuário.
        (window.requestIdleCallback || setTimeout)(build);

        storyButton.addEventListener('click', function () {
            (storyFile ? Promise.resolve(storyFile) : build()).then(function (file) {
                copy(story.url).catch(function () {});

                if (navigator.canShare && navigator.canShare({ files: [file] })) {
                    navigator.share({ files: [file], title: story.title })
                        .then(function () { notify('Link copiado. No story, use o adesivo de link e cole.'); })
                        .catch(function (error) {
                            if (error.name !== 'AbortError') {
                                download(file);
                            }
                        });

                    return;
                }

                download(file);
                notify('Imagem do story baixada e link copiado. Publique pelo celular e cole o link no adesivo.');
            });
        });
    })();
</script>
