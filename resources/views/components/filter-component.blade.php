@props(['category' => null])

<div class="card col-md-12">
    <div style="padding: 10px 0px;">
        <div class="filter">
            <div class="view-filter">
                <span id="filter-open" style="display: none;" class="filter-open"><i class="fas fa-filter"></i></span>
                <span class="grid active" id="grid"><i class="fas fa-th"></i></span>
                <span class="list" id="list"><i class="icofont icofont-listine-dots"></i></span>
            </div>

            <div class="short">
                <h4>
                    {{-- <span id="category-name"></span>

                    <script>
                        // Get current URL
                        const url = window.location.href;

                        // Get the last part of URL
                        const parts = url.split('/');
                        let category = parts[parts.length - 1];

                        // Replace '-' with space and capitalize each word
                        category = category
                            .split('-')
                            .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                            .join(' ');

                        // Set the text inside the span
                        document.getElementById('category-name').textContent = category;
                    </script> --}}

<span id="category-name"></span>

<script>
    const url = new URL(window.location.href);

    // Get sub_category from query string or fallback to last path
    let category = url.searchParams.get('sub_category');
    if (!category) {
        const pathParts = url.pathname.split('/');
        category = pathParts[pathParts.length - 1];
    }

    // Decode URI (to handle +, %20, %26 etc.)
    category = decodeURIComponent(category);

    // Replace '-' with space, capitalize each word, keep '&'
    category = category
        .split(/[\s-]+/)          // Split by space or hyphen
        .map(word => {
            // If word is just '&', keep it
            if (word === '&') return '&';
            return word.charAt(0).toUpperCase() + word.slice(1);
        })
        .join(' ');

    document.getElementById('category-name').textContent = category;
</script>



                </h4>
            </div>
        </div>
    </div>
</div>
