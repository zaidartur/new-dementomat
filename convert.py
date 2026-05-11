import os
import re

out_dir = 'resources/views/layouts/metronic'
os.makedirs(out_dir, exist_ok=True)

for i in range(1, 18):
    layout_name = f'layout-{i}'
    html_path = f'_metronic-tailwind-html-starter-kit/dist/html/{layout_name}/index.html'
    if not os.path.exists(html_path):
        continue
        
    with open(html_path, 'r', encoding='utf-8') as f:
        html = f.read()
        
    # Replace the styles.css link with @vite
    html = html.replace('<link href="assets/css/styles.css" rel="stylesheet"/>', '<link href="{{ asset(\'assets/css/styles.css\') }}" rel="stylesheet"/>\n  @vite([\'resources/metronic/css/styles.css\', \'resources/js/app.js\'])')
    
    # Fix asset paths for css, js, media, vendors using regex
    html = re.sub(r'href="(assets/[^"]+)"', r'href="{{ asset(\'\1\') }}"', html)
    html = re.sub(r'src="(assets/[^"]+)"', r'src="{{ asset(\'\1\') }}"', html)
    
    # Remove core.bundle.js and demo.js since we use Vite
    html = re.sub(r'<script src="\{\{ asset\(\'assets/js/core\.bundle\.js\'\) \}\}">\s*</script>', '', html)
    html = re.sub(r'<script src="\{\{ asset\(\'assets/js/layouts/demo.*?\.js\'\) \}\}">\s*</script>', '', html)
    
    # Replace Content
    html = re.sub(r'<!-- Content -->(.*?)<!-- End of Content -->', '''<!-- Content -->
    <main class="grow pt-5" id="content" role="content">
     <div class="kt-container-fixed" id="contentContainer">
      {{ $slot }}
     </div>
    </main>
    <!-- End of Content -->''', html, flags=re.DOTALL)
    
    # Clean up base href
    html = re.sub(r'<base href="(.*?)">', '', html)
    
    with open(f'{out_dir}/{layout_name}.blade.php', 'w', encoding='utf-8') as f:
        f.write(html)
        
print('Done!')
