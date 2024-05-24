<style>
    .candiadte-documents {
        display: flex;
        flex-flow: row nowrap;
        overflow-y: hidden;
        overflow-x: scroll;
    }

    .candiadte-documents::-webkit-scrollbar {
        height: 10px
    }

    .candiadte-documents::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .candiadte-documents::-webkit-scrollbar-thumb {
        background: #d2d2d2;
        border-radius: 50px;
    }

    .candidate-document-list {
        flex: 0 0 27%;
        border: 1px solid #e9e9e9;
        padding: 20px 15px;
        display: flex;
    }

    .document-number {
        height: 25px;
        width: 25px;
        background: #004e94;
        border-radius: 100%;
        text-align: center;
        line-height: 25px;
        color: #fff;
        font-size: 14px;
        font-weight: 500;
    }

    .document-details {
        width: calc(100% - 25px);
        padding-left: 15px;
    }

    .document-details h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
        color: #004e94;
        margin-bottom: 20px;
    }

    .candidate-document-list a {
        display: inline-block;
        color: #004e94 !important;
        font-weight: 500;
    }

    .candidate-document-list a i {
        font-size: 18px;
        vertical-align: middle;
        margin-right: 1px;
    }

    .candidate-document-list img {
        height: 80px !important;
        width: auto !important;
        border-radius: 5px;
        margin-bottom: 20px;
        margin-right: 10px;
    }

    .candidate-document-list ul {
        padding-left: 0;
    }

    .candidate-document-list ul li {
        list-style: none;
        margin-bottom: 7px;
    }

    .document-details ul li:last-child {
        margin-top: 20px;
    }

    .document-details ul li:last-child b {
        margin-bottom: 10px;
        display: block;
        font-weight: 600;
        font-size: 14px;
    }

    .flight-details span {
        margin-bottom: 20px;
        display: block;
    }

    .medical-img p {
        margin-bottom: 0;
        margin-top: 20px;
    }
</style>
<div class="candiadte-documents">
    <div class="candidate-document-list">
        <div class="document-number">
            1
        </div>
        <div class="document-details">
            <h3>Profile</h3>
            <div class="profile-img">
                <img src='{{ asset('no-profile.jpg') }}' alt='profile image' style='height: 5rem;width: auto;'>
            </div>
        </div>
    </div>
    <div class="candidate-document-list">
        <div class="document-number">
            2
        </div>

    </div>

</div>
