<?php
include("header.php");
?>
<div class="navbar">
  <div class="navbar-inner">
    <div class="container">
      <ul class="nav">
        <li<?php if ($page === null) { echo " class=\"active\""; } ?>><a href="./">Home</a></li>
        <li<?php if ($page === "profile") { echo " class=\"active\""; } ?>><a href="/profile">Profile</a></li>
        <li<?php if ($page === "about") { echo " class=\"active\""; } ?>><a href="/about">About</a></li>
        <li<?php if ($page === "contact") { echo " class=\"active\""; } ?>><a href="/contact">Contact</a></li>
      </ul>
    </div>
  </div>
</div>

<!-- Jumbotron -->
<div class="jumbotron">
  <div id="banner"></div>
  <h1>Get what you want, when you want it</h1>
  <h2>Connect with local businesses in real time</h2>
</div>


<div class="row-fluid">
  <div class="span12">
    <h2>Add Your Business</h2>
    <label>Business Name</label><input type="text" />
    <label>Upload Logo</label><input type="file" />
    <label>Address Line 1</label><input type="text" />
    <label>Address Line 2</label><input type="text" />
    <label>City</label><input type="text" />
    <label>State</label><select><option>Select State</option></select>
    <label>Zip Code</label><input type="text" />
    <label>User Agreement</label>
    <div style="border: 1px solid #ccc; padding: 5px;height: 260px;overflow-y: scroll; width: 600px;">
      <strong>User Agreement and License</strong>
      <p>This license agreement is an integral part of the service agreement between user and Murray Hill Learning Group, Inc., DBA Fancy Chatter, Inc. (hereinafter referred to as “Company”), and must be read before using www.fancychatter.com, (“Website” or “Site”).  Once this agreement has been signed or you have begun use of the website, you have accepted all the terms and conditions of this agreement.</p>
      <strong>1.  Definitions</strong>
      <p>(i)  Site or Website.  The Site or Website means all information, content, concepts, program interfaces, structures, functionality, computer code, published materials, electronic documents, graphic files and other technology inherent in Company’s World Wide Website located at www.fancychatter.com</p>
      <p>(ii)  Software.  The Software, if any, includes all concepts, users and program interfaces and structures, functionality, computer code, and other technology inherent in all computer software programs and all copies of the software supporting any of Company’s electronic commerce tools and products.</p>
      <p>(iii) Databases or Informational Databases.  The Informational Databases or Database includes all information accessible from Company through the Software or the Site, which may include, but is not limited to, data structures, technical and other specifications, pricing, advice, and other data and information.  All data and other information available on the Informational Databases is proprietary, confidential and the sole property of Company or third parties licensing such information to Company.</p>
      <strong>2.  Security</strong>
      <p>You must enter a valid ID and password (“access codes”) to access  certain Software, Databases or the Website’s (collectively, the “product”) secure areas.  It is your sole responsibility to monitor use of these access codes for all purposes.  You accept all responsibility for the security of your user ID and password, and utilization of the product via the access codes.  This includes unauthorized access by your employees or third parties, except for access by third parties resulting from Company’s sole negligence.  You have the ability to modify your password at any time.  Company recommends you modify your password regularly.  Notify Company immediately if you wish to terminate your master user ID and password or have these access codes reissued.  Do not disclose your access codes to anyone not authorized to act on your behalf.</p>
      <strong>3.  Payment and Term Agreement</strong>
      <p>Unless otherwise stated in an express written agreement signed by an officer of the Company, the terms and conditions contained in Company’s attached Payment and Term Agreement, as amended from time to time, shall apply to all use and transactions initiated through the product.</p>
      <strong>4.  Termination and Modification</strong>
      <p>Company may elect to update, modify, change, or terminate all or any part of the functionality available through the product.  Company may modify this agreement from time to time.  Any amendments or modifications may be provided to you through on-line notice.  You agree that use and access to the product after you have, or should have received, notice of modifications or amendments to this Agreement will constitute acceptance of all such modifications or amendments.  You agree on termination of this agreement to cease accessing the product, and to return any Software, if any provided.  The product’s secure areas are confidential information of the Company or companies licensing Company and contain copyrighted information.</p>
      <strong>5. Grant of License</strong>
      The product is not sold, but licensed to you for use in your ordinary course of business.  This license is for the period beginning with your acceptance of this Agreement until termination by you or failure to maintain authorized user status.  The license is non-transferable and non exclusive; and is for use only by your employees engaged in your ordinary course of business, and only in accordance with this agreement and any documentation provided to you or available online from time to time.  

      6.  Proprietary Rights
      The product is copyrighted by and proprietary to the Company.  The company retains title and ownership of all copies of the product.  The nonexclusive license set forth in this Agreement is not a sale of the product or a copy.  You agree to hold the product in confidence and to take all reasonable steps to prevent unauthorized disclosures.

      7.  No Other Rights
      Except as stated above, this Agreement does no grant you any rights to patents, copyrights, trade secrets, trade names, trademarks (whether registered or unregistered, or any other rights, franchises, or license in respect of the product.  You may NOT, except as otherwise provided in documentation or 

      online, (a) copy any of the product; (b) distribute, rent, sublicense or otherwise transfer or disclose, or transmit the product electronically to any person or entity; (c) modify, translate, merge, or prepare derivative works of the product, or (d) use any of the product for service bureau or other purposes not specified in this Agreement or the documentation.  You may not decompile, disassemble, probe, or otherwise reverse engineer the product.


      8.  Disclaimer of Warranty; Limitation of Remedies
      Company is licensing the product “AS IS” and “AS AVAILABLE.”  You acknowledge that the product is licensed tfor use by you as a convenience for you in the ordinary course of business.  You assume total responsibility and risk for your use of the product and your use of the internet.
      a.  COMPANY HEREBY DISCLAIMS ALL WARRANTIES REPRESENTATION AND CONDITIONS, STATUATROY OR OTHERWISE EXPRESS OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTY OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE WITH REGARD TO ANY MERCHANDISE, INFORMATION OR SERVICE PROVIDED THROUGH THE PRODUCT.
      b. THE COMPANY DOES NOT AND CANNOT WARRANT THE PERFORMANCE OR RESULTS YOU MAY OBTAIN BY USING THE PRODUCT.
      Your sole and exclusive remedy for any breach of this Agreement by Company shall be to terminate the Agreement.
      c.  IN NO EVENT WILL COMPANY BE LIABLE TO YOU FOR ANY DAMAGES OR SPECIAL DAMAGES, INCLUDING ANY LOST PROFITS, LOST SAVINGS OR OTHER INCIDENTAL OR CONSEQUENTIAL DAMAGES, EVEN IF COMPANY OR ANY COMPANY REPRESENTIVIE HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES, OR FOR ANY CLAIM BY ANY OTHER PARTY.  
      Additional Disclaimers may be contained in the product.

      9. Governing Law.
      This Agreement and your use of the product are governed by internal Indiana law and applicable federal laws of the United States.  The venue for any disputes arising out of this Agreement shall be, at Company’s sole and exclusive option, the courts with proper jurisdiction at Company’s corporate headquarters, or the courts with proper jurisdiction at your location.


      10.  Your Obligations 
      You agree that you shall not use the product to do any of the following: (i) restrict or inhibit any other user from using and enjoying the product; (ii) post or transmit any unlawful, illegal, obscene or pornographic information of any king, including, without limitation, any transmissions constituting or encouraging conduct that would constitute a criminal offense, give rise to civil liability or otherwise violate any local, state, national or international law; (iii) knowingly post or transmit any information or software which contains a virus, worm, cancelbot or other harmful component; (iv) upload, post, publish, transmit, reproduce, distribute, or participate in the transfer or sale, or in any way exploit information, software or other material obtained through the product that is protected by copyright or other proprietary right or derivative works with respect thereto, without obtaining permission of the copyright owner or right holder.  In addition you may not effect or participate in any activity to (a) post to any use net or other news group, forum, Email listing or similar group or list articles which are off topic according to the charter or other public statements of the group or list; (b) send unsolicited mass mailings; or (c) falsify or “spoof” user information provided to Company or to other users in connection with the use of the product.
      11.  Indemnity
      You agree to defend, indemnify and hold Company and its affiliates, and its and their directors, employees and agents harmless from any and all liabilities, costs and expenses, including reasonable attorney fees related to or arising from (a) negligent acts or omissions by you in connection with the installations, use or maintenance of the product; (b) claims for infringement of patents arising from the use of the product by you other than for its intended purpose, and (c) claims of copyright infringement resulting from the use of the product by you other than for its intended purpose.

      IN WITNESS WHEREOF, the parties have caused this Term and Payment Agreement to be executed by their respective duly authorized representatives.
      Requested and Agreed to by Client Agreed to and Accepted by Fancy Chatter, 
      Client Authorized Signature:
    </div>
    <br />
    <button type="button" class="btn btn-mini btn-success search-btn" onclick="livechatter.search();">Submit Application</button>
  </div>
</div>
<?php
include("footer.php");
?>
