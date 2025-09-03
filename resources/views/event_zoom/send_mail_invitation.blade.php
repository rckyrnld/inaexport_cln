<div align="center" style="width: 100%">
    <div align="center" style="width: 580px;">
        <img height="100%" width="580px" src="{{ url('assets') }}/assets/images/headeremail3.png" alt=".">
        <p
            style="text-align: left; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 18px;">
            Dear {{ $user }} {{ $badanusaha }},</P>
        <p
            style="text-align: left; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 18px;">
            You have invited to business matching meeting, see detail below this Zoom meeting.
        </p>
        <table>
            <tr>
                <td>
                    <span
                        style="text-align: left; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 18px;">
                        Topic</span>
                </td>
                <td>:</td>
                <td>
                    <span
                        style="text-align: left; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 18px;">
                        {{ $topic }}</span>
                </td>
            </tr>
            <tr>
                <td>
                    <span
                        style="text-align: left; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 18px;">
                        Zoom Meeting ID </span>
                </td>
                <td>:</td>
                <td>
                    <span
                        style="text-align: left; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 18px;">
                        {{ $meeting_id }} </span>
                </td>
            </tr>
            <tr>
                <td>
                    <span
                        style="text-align: left; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 18px;">
                        Password </span>
                </td>
                <td>:</td>
                <td>
                    <span
                        style="text-align: left; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 18px;">
                        {{ $password }} </span>
                </td>
            </tr>
            <tr>
                <td>
                    <span
                        style="text-align: left; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 18px;">
                        Time</span>
                </td>
                <td>:</td>
                <td>
                    <span
                        style="text-align: left; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 18px;">
                        {{ $time }} Jakarta</span>
                </td>
            </tr>
        </table>
        <br />
        <img height="100%" width="580px" src="{{ url('assets') }}/assets/images/footeremail3.png" alt=".">
    </div>
</div>
