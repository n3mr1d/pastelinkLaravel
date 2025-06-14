<footer>
        <div class="about">
            <h3>About {{ config("app.name") }}</h3>
            <p>{{ config("app.name") }} is a website that provides links to access various services on the dark web, which can only be accessed using a special browser like Tor. The site acts as a directory connecting users to hidden content on the internet. While offering anonymity, the dark web also carries significant risks, including illegal and harmful content.</p>
        </div>
        <div class="donate">
            <h3>Support Our Service</h3>
            <p>Help us keep {{ config("app.name") }} running and ad-free by donating:</p>
            <div class="crypto-donations">
                <div class="crypto">
                    <span class="crypto-name">Bitcoin:</span>
                    <span class="crypto-address">bc1qxy2kgdygjrsqtzq2n0yrf2493p83kkfjhx0wlh</span>
                </div>
                <div class="crypto">
                    <span class="crypto-name">Ethereum:</span>
                    <span class="crypto-address">0x71C7656EC7ab88b098defB751B7401B5f6d8976F</span>
                </div>
            </div>
            <div class="donate-message">
                <p>Your support helps us maintain our infrastructure and develop new features.</p>
                <p>Thank you for being part of our community!</p>
            </div>
        </div>
</footer>