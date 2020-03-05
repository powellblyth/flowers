// CardSection.js
import React from 'react';

class AddressSection extends React.Component {
    render() {
        console.log(this.props)
        return (
            <div>
                <div className="row">
                    <div className="col-md-2 col-lg-2 col-sm-12">
                        <b>Name:</b> {this.props.name}
                    </div>
                    <div className="col-md-10 col-lg-10 col-sm-12">
                        <input name="name" id="name" defaultValue={this.props.name} />
                    </div>
                </div>
                <div className="row">
                    <div className="col-md-2 col-lg-2 col-sm-12">
                        <b>Address line 1:</b>
                    </div>
                    <div className="col-md-10 col-lg-10 col-sm-12">
                        <input name="address_line1" id="address_line1" defaultValue={this.props.address_line1} />
                    </div>
                </div>
                <div className="row">
                    <div className="col-md-2 col-lg-2 col-sm-12">
                        <b>Address line 2:</b>
                    </div>
                    <div className="col-md-10 col-lg-10 col-sm-12">
                        <input name="address_line2" id="address_line2" defaultValue={this.props.address_line2} />
                    </div>
                </div>
                <div className="row">
                    <div className="col-md-2 col-lg-2 col-sm-12">
                        <b>Town / City:</b>
                    </div>
                    <div className="col-md-10 col-lg-10 col-sm-12">
                        <input name="address_city" id="address_city" defaultValue={this.props.address_city} />
                    </div>
                </div>
                <div className="row">
                    <div className="col-md-2 col-lg-2 col-sm-12">
                        <b>Postcode:</b>
                    </div>
                    <div className="col-md-10 col-lg-10 col-sm-12">
                        <input name="address_zip" id="address_zip" defaultValue={this.props.address_zip} />
                    </div>
                </div>
            </div>
        );
    }
}

export default AddressSection;