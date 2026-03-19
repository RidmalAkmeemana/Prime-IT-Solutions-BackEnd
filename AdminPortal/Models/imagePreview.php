<style>
    /* Fullscreen Image Preview */
    .custom-image-modal {
        display: none;
        position: fixed;
        z-index: 99999;
        padding-top: 60px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.9);
        text-align: center;
    }

    .custom-image-modal img {
        margin: auto;
        display: block;
        max-width: 85%;
        max-height: 85%;
        border-radius: 10px;
        animation: zoomIn 0.3s ease;
    }

    @keyframes zoomIn {
        from { transform: scale(0.8); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    /* Close Button */
    .close-preview {
        position: absolute;
        top: 25px;
        right: 40px;
        color: #fff;
        font-size: 40px;
        font-weight: 300;
        cursor: pointer;
        transition: 0.3s;
    }

    .close-preview:hover {
        transform: scale(1.2);
        color: #b19316;
    }
</style>


<!-- Image Preview Modal -->
<div id="imagePreviewModal" class="custom-image-modal">
    <span class="close-preview">&times;</span>
    <img class="preview-content" id="fullPreviewImage">
</div>